<?php

namespace Tests\Feature\LocationServiceHour;

use App\Models\Location;
use App\Models\LocationServiceHour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $locationUser;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->locationUser = User::factory()->create();
        $this->location = Location::factory()->for($this->locationUser)->create();
    }

    public function testWhenLocationServiceHourDisplayed()
    {
        // GIVEN
        $LocationServiceHour = LocationServiceHour::factory()->for($this->location)->create($data = [
            'weekday' => 3,
        ]);
        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->getJson(route('location-service-hours.show', [
            'location' => $this->location->id,
            'location_service_hour' => $LocationServiceHour->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenLocationNotFound()
    {
        // GIVEN
        $LocationServiceHour = LocationServiceHour::factory()->for($this->location)->create([
            'weekday' => 3,
        ]);
        $faker = \Faker\Factory::create();
        $locationId = $faker->numberBetween(100, 300);
        $expected = [
            'data' => "Location(ID:{$locationId}) is not found.",
        ];

        // WHNE
        $response = $this->getJson(route('location-service-hours.show', [
            'location' => $locationId,
            'location_service_hour' => $LocationServiceHour,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenLocationServiceHourNotFound()
    {
        // GIVEN
        $faker = \Faker\Factory::create();
        $locationServiceHourId = $faker->numberBetween(100, 300);
        $expected = [
            'data' => "LocationServiceHour(ID:{$locationServiceHourId}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('location-service-hours.show', [
            'location' => $this->location->id,
            'location_service_hour' => $locationServiceHourId,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
