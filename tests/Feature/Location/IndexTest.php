<?php

namespace Tests\Feature\Location;

use App\Enums\LocationCategoryEnum;
use App\Http\Resources\LocationCollection;
use App\Models\City;
use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  @var CityArea
     */
    protected $cityArea;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CityAndAreaSeeder::class);
        $this->cityArea = CityArea::inRandomOrder()->first();
    }

    public function testLocationsQueriedByCategoryIdAndCityId()
    {
        // GIVEN
        $locations = collect();
        $categoryId = LocationCategoryEnum::RESTAURANTS;
        $cityId = City::inRandomOrder();
        User::factory(3)->create()->each(function ($user) use ($locations, $categoryId) {
            $locations->push(Location::factory()->for($user)->create([
                'category_id' => $categoryId,
                'city_area_id' => $this->cityArea->id,
                'active' => 1,
            ]));
        });

        foreach ($locations = (new LocationCollection($locations))->jsonSerialize() as $index => $location) {
            $locations[$index]['user'] = $locations[$index]['user']->toArray();
        }

        $expected = [
            'data' => $locations
        ];

        // WHEN
        $response = $this->getJson(route('locations.index') . '?' . http_build_query([
            'category_id' => $categoryId,
            'city_id' => $cityId,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testLocationsQueriedByCategoryIdAndRanking()
    {
        // GIVEN
        $locations = collect();
        $categoryId = LocationCategoryEnum::RESTAURANTS;
        User::factory(3)->create()->each(function ($user, $i) use ($locations, $categoryId) {
            $locations->push(Location::factory()->for($user)->create([
                'category_id' => $categoryId,
                'city_area_id' => $this->cityArea->id,
                'active' => 1,
                'avgScore' => $i + 1,
            ]));
        });
        
        $locations = $locations->sortByDesc('avgScore');
        foreach ($locations = (new LocationCollection($locations))->jsonSerialize() as $index => $location) {
            $locations[$index]['user'] = $locations[$index]['user']->toArray();
        }

        $expected = [
            'data' => $locations,
        ];

        // WHEN
        $response = $this->getJson(route('locations.index') . '?' . http_build_query([
            'category_id' => $categoryId,
            'ranking' => 6,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
