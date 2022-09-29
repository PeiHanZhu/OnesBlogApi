<?php

namespace Tests\Feature\Post;

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
        $location = Location::factory()->for($locationUser)->create();
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($location)->create($data = [
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);

        $data = array_diff_key($data, array_flip([
            'user_id',
            'active',
        ]));
        $expected = [
            'data' => [
                array_merge(
                    $data,
                    ['user' => ['id' => $postUser->id]]
                ),
            ],
        ];

        // WHEN
        $response = $this->getJson(route('posts.index') . '?' . http_build_query([
            'category_id' => $post->location->category_id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
