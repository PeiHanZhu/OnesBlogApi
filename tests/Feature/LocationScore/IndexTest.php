<?php

namespace Tests\Feature\LocationScore;

use App\Http\Resources\LocationScoreCollection;
use App\Http\Resources\LocationScoreResource;
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
        $locationScores = collect();
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        User::factory(5)->create()->each(function($user) use ($locationScores, $location){
            $locationScores->push(LocationScore::factory()->for($user)->for($location)->create([
                'score' => 3.5,
            ]));
        });
        foreach ($locationScores = (new LocationScoreCollection($locationScores))->jsonSerialize() as $index => $locationScore) {
            $locationScores[$index]['user'] = $locationScores[$index]['user']->toArray();
            $locationScores[$index]['location'] = $locationScores[$index]['location']->toArray();
        }

        $expected = [
            'data' => $locationScores
        ];

        // WHEN
        $response = $this->getJson(route('location-scores.index') . '?' . http_build_query([
            'location_id' => $location->id,
            // 'user_id' => $user->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
