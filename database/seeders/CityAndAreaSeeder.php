<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CityAndAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(database_path('data/city_towns.json')), true);
        $cityAreas = collect($data)->groupBy('city_name')->map(function ($towns) {
            return $towns->pluck('zipcode', 'name');
        });
        $originalCityAreas = City::with('cityAreas')->get();
        $cityAreas->each(function ($towns, $city) use ($originalCityAreas) {
            if (is_null($originalCity = $originalCityAreas->firstWhere('city', $city))) {
                $originalCity = City::create([
                    'city' => $city,
                ]);
            }
            $towns->each(function ($zipCode, $townName) use ($originalCity) {
                if (is_null($originalTown = $originalCity->cityAreas->firstWhere('city_area', $townName))) {
                    $originalCity->cityAreas()->create([
                        'city_area' => $townName,
                        'zip_code' => $zipCode,
                    ]);
                } else {
                    $originalTown->update([
                        'zip_code' => $zipCode,
                    ]);
                }
            });
        });
    }
}
