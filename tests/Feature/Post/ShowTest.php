<?php

namespace Tests\Feature\Post;

use App\Enums\PostCategoryEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
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
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->store = User::factory()->create([
            'is_store' => 1,
        ]);
    }

    public function testShow()
    {
        // GIVEN
        $post = Post::factory()->create($data = [
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
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
                ['user' => ['id' => $this->user->id]]
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
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
            'active' => 0,
        ]);

        $expected = [
            'data' => 'Post not found',
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
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
            'published_at' => now()->addHours(6),
        ]);

        $expected = [
            'data' => 'Post not found',
        ];

        // WHEN
        $response = $this->getJson(route('posts.show', [
            'post' => $post->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
