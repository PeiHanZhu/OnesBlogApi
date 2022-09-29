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
    protected $locationUser;

    /**
     * @var Location
     */
    protected $location;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Post
     */
    protected $post;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->locationUser = User::factory()->create();
        $this->location = Location::factory()->for($this->locationUser)->create();
        $this->user = User::factory()->create();
        $this->post = Post::factory()->for($this->user)->for($this->location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
    }

    public function testWhenCommentDisplayed()
    {
        // GIVEN
        $comment = Comment::factory()->for($this->user)->for($this->post)->create($data = [
            'content' => 'test',
        ]);
        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->getJson(route('comments.show', [
            'post' => $this->post->id,
            'comment' => $comment->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenCommentNotFound()
    {
        // GIVEN
        $faker = \Faker\Factory::create();
        $commentId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "Comment(ID:{$commentId}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('comments.show', [
            'post' => $this->post->id,
            'comment' => $commentId,
        ]));

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
