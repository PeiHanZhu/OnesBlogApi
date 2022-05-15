<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var User
     */
    protected $store;

    /**
     * @var Post
     */
    protected $post;

    public function testShow()
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
        $comment = Comment::factory()->create($data = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => 'test',
        ]);
        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->getJson(route('comments.show', [
            'post' => $post->id,
            'comment' => $comment->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
