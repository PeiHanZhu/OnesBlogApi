<?php

namespace Tests\Feature\LocationLike;

use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationLikeCollection;
use App\Models\Location;
use App\Models\LocationLike;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenLocationLikesDisplayed()
    {
        // GIVEN
        $locations = collect();
        $locationLikes = collect();
        $likeUser = User::factory()->create();
        User::factory(5)->create()->each(function ($user) use ($locations, $locationLikes, $likeUser){
            $locations->push($location = Location::factory()->for($user)->create([
                'active' => 1,
            ]));
            $locationLikes->push(LocationLike::factory()->for($likeUser)->for($location)->create());
        });

        foreach ($locationLikes = (new LocationLikeCollection($locationLikes))->jsonSerialize() as $index => $locationLike) {
            $locationLikes[$index]['user'] = $locationLikes[$index]['user']->toArray();
            $locationLikes[$index]['location'] = $locationLikes[$index]['location']->toArray();
        }

        $expected = [
            'data' => $locationLikes,
        ];

        // WHEN
        $response = $this->getJson(route('location-likes.index'), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenLocationLikesQueriedByUserId()
    {
        // GIVEN
        // TODO: 待完成
        $locations = collect();
        $likeUser = User::factory()->create();
        User::factory(5)->create()->each(function ($user) use ($locations, $likeUser){
            $locations->push($location = Location::factory()->for($user)->create([
                'active' => 1,
            ]));
            LocationLike::factory()->for($likeUser)->for($location)->create();
        });

        foreach ($locations = (new LocationCollection($locations))->jsonSerialize() as $index => $location) {
            $locations[$index]['user'] = $locations[$index]['user']->toArray();
            // $locations[$index]['location'] = $locations[$index]['location']->toArray();
        }

        $expected = [
            'data' => $locations
        ];

        // WHEN
        $response = $this->getJson(route('location-likes.index') . '?' . http_build_query([
            'user_id' => $likeUser->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
