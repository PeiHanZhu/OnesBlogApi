<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testDestroy()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);

        $post = Post::factory()->for($postUser)->for($location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $postUser->id,
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
