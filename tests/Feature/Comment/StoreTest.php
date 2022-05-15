<?php

namespace Tests\Feature\Comment;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
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
        $expected = [
            'data' => $data = [
                'user_id' => $user->id,
                'post_id' => $post->id,
                'content' => 'XUN',
            ],
        ];

        // WHEN
        $response = $this->postJson(route('comments.store', [
            'post' => $post->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }
}
