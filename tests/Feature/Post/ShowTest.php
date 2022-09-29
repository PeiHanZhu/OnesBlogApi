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
     * @var User
     */
    protected $postUser;

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

    public function testWhenPostDisplayed()
    {
        // GIVEN
        $post = Post::factory()->for($this->postUser)->for($this->location)->create($data = [
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

    public function testWhenPostShowInactive()
    {
        // GIVEN
        $post = Post::factory()->for($this->postUser)->for($this->location)->create([
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

    public function testWhenPostUnpublished()
    {
        // GIVEN
        $post = Post::factory()->for($this->postUser)->for($this->location)->create([
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

    public function testWhenPostNotFound()
    {
        // GIVEN
        $faker = \Faker\Factory::create();
        $postId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "Post(ID:{$postId}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('posts.show', [
            'post' => $postId,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
