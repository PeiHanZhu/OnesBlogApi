<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var Post
     */
    protected $post;

    public function testShow()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $user = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'location_id' => $location->id,
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
