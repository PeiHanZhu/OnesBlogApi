<?php

namespace Tests\Feature\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroy()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $store = User::factory()->create([
            'is_store' => 1
        ]);
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'store_id' => $store->id,
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'test',
        ]);
        $expected = [
            'data' => 'Success'
        ];

        // WHEN
        $response = $this->deleteJson(route('comments.destroy', [
            'post' => $post->id,
            'comment' => $comment->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
