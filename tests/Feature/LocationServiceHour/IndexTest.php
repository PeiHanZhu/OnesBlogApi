<?php

namespace Tests\Feature\LocationServiceHour;

use App\Http\Resources\LocationServiceHourCollection;
use App\Models\Location;
use App\Models\LocationServiceHour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testLocationServiceHours()
    {
        // GIVEN
        $locationServiceHours = collect();
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        foreach (range(1, 3) as $i) {
            $locationServiceHours->push(
                LocationServiceHour::factory()
                    ->for($location)->create([
                        'weekday' => 2,
                    ])
            );
        }
        $expected = [
            'data' => (new LocationServiceHourCollection($locationServiceHours))->jsonSerialize()
        ];

        // WHEN
        $response = $this->getJson(route('location-service-hours.index', [
            'location' => $location->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
