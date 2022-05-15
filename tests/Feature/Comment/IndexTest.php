<?php

namespace Tests\Feature\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        // GIVEN
        $user = User::factory()->create();
        $store = User::factory()->create([
            'is_store' => 1
        ]);
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'store_id' => $store->id,
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $post->comments()->create($data = [
            'user_id' => $user->id,
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
