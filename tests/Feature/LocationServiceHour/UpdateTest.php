<?php

namespace Tests\Feature\LocationServiceHour;

use App\Models\Location;
use App\Models\LocationServiceHour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenLocationServiceHourUpdated()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create([
            'weekday' => 3,
        ]);
        $data = [
            'weekday' => 2,
        ];
        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->putJson(route('location-service-hours.update', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create([
            'weekday' => 3,
        ]);
        $data = [
            'weekday' => 2,
        ];
        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->putJson(route('location-service-hours.update', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenLocationUpdatedByWrongUser()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create([
            'weekday' => 2,
        ]);
        Sanctum::actingAs(User::factory()->create());
        $data = [
            'weekday' => 3,
        ];
        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->putJson(route('location-service-hours.update', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenLocationNotFound()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create([
            'weekday' => 2,
        ]);
        $data = [
            'weekday' => 3,
        ];
        $faker = \Faker\Factory::create();
        $locationId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "Location(ID:{$locationId}) is not found."
        ];

        // WHEN
        $response = $this->putJson(route('location-service-hours.update', [
            'location' => $locationId,
            'location_service_hour' => $locationServiceHour->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenLocationServiceHourNotFound()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $faker = \Faker\Factory::create();
        $locationServiceHourId = $faker->numberBetween(100, 300);
        $data = [
            'weekday' => 3,
        ];
        $expected = [
            'data' => "LocationServiceHour(ID:{$locationServiceHourId}) is not found.",
        ];

        // WHEN
        $response = $this->putJson(route('location-service-hours.show', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHourId,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create([
            'weekday' => 3,
        ]);
        $data = [];
        $expected = [
            'data' => [
                'weekday' => [
                    __('validation.required')
                ],
            ],
        ];

        // WHEN
        $response = $this->putJson(route('location-service-hours.update', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
