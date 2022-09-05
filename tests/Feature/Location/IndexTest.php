<?php

namespace Tests\Feature\Location;

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

    public function testLocationQueriedByCategoryIdAndCityId()
    {
        // GIVEN
        $user = User::factory()->create();
        $this->seed(CityAndAreaSeeder::class);
        $cityArea = CityArea::inRandomOrder()->first();
        $location = Location::factory()->create($data = [
            'user_id' => $user->id,
            'city_area_id' => $cityArea->id,
        ]);
        $data = array_diff_key($data, array_flip([
            'user_id', 'city_area_id'
        ]));

        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->getJson(route('locations.index') . '?' . http_build_query([
            'category_id' => $location->category_id,
            'city_id' => $location->cityArea->city_id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testLocationQueriedByCategoryIdAndRandom()
    {
        // GIVEN
        $user = User::factory()->create();
        $this->seed(CityAndAreaSeeder::class);
        $cityArea = CityArea::inRandomOrder()->first();
        $location = Location::factory()->create($data = [
            'user_id' => $user->id,
            'city_area_id' => $cityArea->id,
        ]);
        $data = array_diff_key($data, array_flip([
            'user_id', 'city_area_id'
        ]));

        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->getJson(route('locations.index') . '?' . http_build_query([
            'category_id' => $location->category_id,
            'random' => true,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testLocationQueriedByCategoryIdAndRanking()
    {
        // GIVEN
        $user = User::factory()->create();
        $this->seed(CityAndAreaSeeder::class);
        $cityArea = CityArea::inRandomOrder()->first();
        $location = Location::factory()->create($data = [
            'user_id' => $user->id,
            'city_area_id' => $cityArea->id,
        ]);
        $data = array_diff_key($data, array_flip([
            'user_id', 'city_area_id'
        ]));

        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->getJson(route('locations.index') . '?' . http_build_query([
            'category_id' => $location->category_id,
            'ranking' => true,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
