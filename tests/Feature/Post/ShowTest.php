<?php

namespace Tests\Feature\Post;

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
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->locationUser = User::factory()->create();
        $this->location = Location::factory()->for($this->locationUser)->create();
        $this->postUser = User::factory()->create();
    }

    public function testShow()
    {
        // GIVEN
        $post = Post::factory()->create($data = [
            'user_id' => $this->postUser->id,
            'location_id' => $this->location->id,
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);

        $data = array_diff_key($data, array_flip([
            'user_id',
            'active',
        ]));
        $expected = [
            'data' =>
            array_merge(
                $data,
                ['user' => ['id' => $this->postUser->id]]
            ),
        ];

        // WHEN
        $response = $this->getJson(route('posts.show', [
            'post' => $post->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testShowInactive()
    {
        // GIVEN
        $post = Post::factory()->create([
            'user_id' => $this->postUser->id,
            'location_id' => $this->location->id,
            'title' => 'Test',
            'active' => 0,
        ]);

        $expected = [
            'data' => "Post(ID:{$post->id}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('posts.show', [
            'post' => $post->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testShowUnpublished()
    {
        // GIVEN
        $post = Post::factory()->create([
            'user_id' => $this->postUser->id,
            'location_id' => $this->location->id,
            'title' => 'Test',
            'published_at' => now()->addHours(6),
        ]);

        $expected = [
            'data' => "Post(ID:{$post->id}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('posts.show', [
            'post' => $post->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
