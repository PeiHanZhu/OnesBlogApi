<?php

namespace Tests\Feature\LocationServiceHour;

use App\Models\Location;
use App\Models\LocationServiceHour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenLocationServiceHourDeleted()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create());
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create();
        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->deleteJson(route('location-service-hours.destroy', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create();

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->deleteJson(route('location-service-hours.destroy', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenLocationDeletedByWrongUser()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create();
        Sanctum::actingAs(User::factory()->create(), ['*']);

        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->deleteJson(route('location-service-hours.destroy', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenLocationNotFound()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create();

        $expected = [
            'data' => "Location(ID:{$location->id}) is not found.",
        ];
        $location->delete(); // Assume that the location had been deleted.

        // WHEN
        $response = $this->deleteJson(route('location-service-hours.destroy', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenLocationServiceHourNotFound()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $locationServiceHour = LocationServiceHour::factory()->for($location)->create();
        $locationServiceHour->delete();
        $expected = [
            'data' => "LocationServiceHour(ID:{$locationServiceHour->id}) is not found.",
        ];

        // WHEN
        $response = $this->deleteJson(route('location-service-hours.show', [
            'location' => $location->id,
            'location_service_hour' => $locationServiceHour->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
