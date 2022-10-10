<?php

namespace Tests\Feature\LocationServiceHour;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenLocationServiceHourCreated()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $data = [
            'opened_at' => '2021-01-01 10:00:00',
            'closed_at' => '2021-01-01 13:00:00',
            'weekday' => 5,
        ];
        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->postJson(route('location-service-hours.store', [
            'location' => $location->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $data = [
            'opened_at' => '2021-01-01 10:00:00',
            'closed_at' => '2021-01-01 13:00:00',
            'weekday' => 5,
        ];
        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->postJson(route('location-service-hours.store', [
            'location' => $location->id,
        ]), $data, $expected);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenLocationStoredByWrongUser()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $data = [
            'weekday' => 3,
        ];
        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->postJson(route('location-service-hours.store', [
            'location' => $location->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        $locationUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($locationUser)->create();
        $data = [];
        $expected = [
            'data' => [
                'weekday' => [
                    __('validation.required')
                ],
            ],
        ];

        // WHEN
        $response = $this->postJson(route('location-service-hours.store', [
            'location' => $location->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
