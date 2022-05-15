<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateTest extends TestCase
{

    use RefreshDatabase;

    public function testUpdate()
    {
        // GIVEN
        $user = User::factory()->create();
        $store = User::factory()->create([
            'is_store' => 1
        ]);
        $post = Post::factory()->create([
            'user_id' => $user->id,
            'store_id' => $store->id,
            'category_id' => 2,
            'title' => '20220510',
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => '0513',
        ]);
        $data = [
            'content' => 'update0513'
        ];
        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->patchJson(route('comments.update', [
            'post' => $post->id,
            'comment' => $comment->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
