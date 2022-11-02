<?php

namespace Tests\Feature\PostKeep;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostKeepCollection;
use App\Models\Location;
use App\Models\Post;
use App\Models\PostKeep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenPostKeepsDisplayed()
    {
        // GIVEN
        $postKeeps = collect();
        $keepUser = User::factory()->create();
        User::factory(5)->create()->each(function ($user) use ($postKeeps, $keepUser){
            $location = Location::factory()->for($user)->create([
                'active' => 1,
            ]);
            $postUser = Sanctum::actingAs(User::factory()->create(), ['*']);
            $post = Post::factory()->for($postUser)->for($location)->create([
                'active' => 1,
            ]);
            $postKeeps->push(PostKeep::factory()->for($keepUser)->for($post)->create());
        });

        foreach ($postKeeps = (new PostKeepCollection($postKeeps))->jsonSerialize() as $index => $postKeep) {
            $postKeeps[$index]['user'] = $postKeeps[$index]['user']->toArray();
            $postKeeps[$index]['post'] = $postKeeps[$index]['post']->toArray();
        }

        $expected = [
            'data' => $postKeeps
        ];

        // WHEN
        $response = $this->getJson(route('post-keeps.index'), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenPostKeepsQueriedByUserId()
    {
        // GIVEN
        $posts = collect();
        $keepUser = User::factory()->create();
        User::factory(5)->create()->each(function ($user) use ($posts, $keepUser){
            $location = Location::factory()->for($user)->create([
                'active' => 1,
            ]);
            $postUser = User::factory()->create();
            $posts->push($post = Post::factory()->for($postUser)->for($location)->create([
                'published_at' => now()->toDateString(),
                'active' => 1,
            ]));
            PostKeep::factory()->for($keepUser)->for($post)->create();
        });

        foreach ($posts = (new PostCollection($posts))->jsonSerialize() as $index => $post) {
            $posts[$index]['user'] = $posts[$index]['user']->toArray();
            $posts[$index]['location'] = $posts[$index]['location']->toArray();
            $posts[$index]['created_at'] = $posts[$index]['created_at']->toISOString();
        }
        $expected = [
            'data' => $posts,
        ];

        // WHEN
        $response = $this->getJson(route('post-keeps.index') . '?' . http_build_query([
            'user_id' => $keepUser->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
