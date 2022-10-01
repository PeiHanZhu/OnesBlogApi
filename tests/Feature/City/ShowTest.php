<?php

namespace Tests\Feature\City;

use App\Http\Resources\CityResource;
use App\Models\City;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenCityDisplayed()
    {
        // GIVEN
        $this->seed(CityAndAreaSeeder::class);
        $city = City::inRandomOrder()->with('cityAreas')->first();

        $expected = [
            'data' => (new CityResource($city))->jsonSerialize(),
        ];

        // WHEN
        $response = $this->getJson(route('cities.show',[
            'city' => $city->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenCityNotFound()
    {
        // GIVEN
        $this->seed(CityAndAreaSeeder::class);
        $faker = \Faker\Factory::create();
        $cityId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "City(ID:{$cityId}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('cities.show',[
            'city' => $cityId,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
