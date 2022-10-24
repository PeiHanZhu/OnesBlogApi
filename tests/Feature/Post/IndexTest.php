<?php

namespace Tests\Feature\Post;

use App\Http\Resources\PostCollection;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testPostsQueriedByCategoryId()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create([
            'active' => 1,
        ]);
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($location)->create($data = [
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);

        $expected = [
            'data' => [
                $data,
            ],
        ];

        // WHEN
        $response = $this->getJson(route('posts.index') . '?' . http_build_query([
            'category_id' => $post->location->category_id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testPostsQueriedByLocationId()
    {
        // GIVEN
        $posts = collect();
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create([
            'active' => 1,
        ]);
        User::factory(5)->create()->each(function ($user) use ($posts, $location) {
            $posts->push(Post::factory()->for($user)->for($location)->create([
                'published_at' => now()->toDateString(),
                'active' => 1,
            ]));
        });
        foreach ($posts = (new PostCollection($posts))->jsonSerialize() as $index => $post) {
            $posts[$index]['user'] = $posts[$index]['user']->toArray();
            $posts[$index]['location'] = $posts[$index]['location']->toArray();
            $posts[$index]['created_at'] = $posts[$index]['created_at']->toISOString();
        }

        $expected = [
            'data' => $posts
        ];
        // WHEN
        $response = $this->getJson(route('posts.index') . '?' . http_build_query([
            'location_id' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testPostsQueriedByUserId()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create([
            'active' => 1,
        ]);
        $user = User::factory()->create();
        Post::factory()->for($user)->for($location)->create($data = [
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $expected = [
            'data' => [
                $data,
            ],
        ];

        // WHEN
        $response = $this->getJson(route('posts.index') . '?' . http_build_query([
            'user_id' => $user->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
