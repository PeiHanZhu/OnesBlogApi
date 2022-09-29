<?php

namespace Tests\Feature\Comment;

use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testComments()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->create(['user_id' => $locationUser->id]);
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $post->comments()->create($data = [
            'user_id' => $postUser->id,
            'content' => 'test',
        ]);

        $expected = [
            'data' => [
                $data
            ],
        ];

        // WHEN
        $response = $this->getJson(route('comments.index', [
            'post' => $post->id,
        ]));

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
