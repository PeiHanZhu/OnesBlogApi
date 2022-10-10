<?php

namespace Tests\Feature\LocationScore;

use App\Models\Location;
use App\Models\LocationScore;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenLocationScoreQueriedByLocationIdAndUserId()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        LocationScore::factory()->for($user)->for($location)->create($data = [
            'score' => 3.5,
        ]);
        $expected = [
            'data' => [
                array_merge(
                    ['user_id' => $user->id],
                    ['location_id' => $location->id],
                    $data
                )
            ]
        ];

        // WHEN
        $response = $this->getJson(route('location-scores.index') . '?' . http_build_query([
            'location_id' => $location->id,
            'user_id' => $user->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
