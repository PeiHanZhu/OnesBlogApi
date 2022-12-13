<?php

namespace Database\Seeders;

use App\Enums\LocationCategoryEnum;
use App\Models\City;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = Location::withCount('user')->get(['id', 'category_id', 'name'])->groupBy('category_id');
        $cityAreas = City::with('cityAreas')->get()->mapWithKeys(function ($city) {
            return [$city->city => $city->cityAreas->pluck('id', 'city_area')];
        })->toArray();
        foreach (LocationCategoryEnum::constants() as $category => $categoryId) {
            $locationsByCategory = $locations->get($categoryId);
            foreach (json_decode(
                file_get_contents(database_path('data/' . strtolower($category) . '.json')),
                true
            ) as $locationInput) {
                $location = $locationsByCategory->firstWhere(
                    'name',
                    $locationName = $locationInput['name']
                ) ?? new Location([
                    'name' => $locationName,
                    'avgScore' => 0,
                ]);
                switch ($categoryId) {
                    case LocationCategoryEnum::RESTAURANTS:
                        $location->city_area_id = data_get($cityAreas, $locationInput['county'] . '.' . $locationInput['town']);
                        break;
                    case LocationCategoryEnum::SPOTS:
                    case LocationCategoryEnum::LODGINGS:
                        if (!empty($areas = data_get($cityAreas, $locationInput['cityname'])) and ($area = array_filter(
                            array_keys($areas),
                            function ($area) use ($locationInput) {
                                return str_contains($locationInput['address'], $area);
                            }
                        ))) {
                            $location->city_area_id = $areas[head($area)];
                        }
                        break;
                }
                $location->category_id = $categoryId;
                $location->address = $locationInput['address'];
                $location->phone = $locationInput['phone'];
                !empty($location->id) ?: $location->active = false;

                $location->user_count ?: $location->user_id = User::factory()->create([
                    'location_applied_at' => now(),
                ])->id;
                $location->save();
                $this->command->line(sprintf(
                    '%s Location had been created or updated: %s',
                    strtolower($category),
                    $location->name
                ));
            }
        }
    }
}
