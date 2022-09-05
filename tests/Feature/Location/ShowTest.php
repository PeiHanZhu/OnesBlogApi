<?php

namespace Tests\Feature\Location;

use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{

    use RefreshDatabase;

    public function testWhenLocationDisplayed()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        $this->seed(CityAndAreaSeeder::class);
        $cityArea = CityArea::inRandomOrder()->first();
        $location = Location::factory()->create($data =
            [
                'user_id' => $user->id,
                'city_area_id' => $cityArea->id,
            ]
        );

        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->getJson(route('locations.show', [
            'location' => $location->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenLocationNotFound()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        $this->seed(CityAndAreaSeeder::class);
        $cityArea = CityArea::inRandomOrder()->first();
        $faker = \Faker\Factory::create();
        $locationId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "Location(ID:{$locationId}) is not found."
        ];

        // WHEN
        $response = $this->getJson(route('locations.show', [
            'location' => $locationId
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
