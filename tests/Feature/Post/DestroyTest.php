<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class DestroyTest extends TestCase
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
     *  {@inheritDoc}
     */
    protected function setup(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->store = User::factory()->create([
            'is_store' => 1,
        ]);
    }

    public function testDestroy()
    {
        // GIVEN
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
            'published_at' => now(),
            'active' => 1,
        ]);

        $expected = [
            'data' => 'Success'
        ];

        // WHEN
        $response = $this->deleteJson(route('posts.destroy', [
            'post' => $post->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testDestroyNotFound()
    {
        // GIVEN
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
            'published_at' => now(),
            'active' => 1,
        ]);

        $expected = [
            'data' => 'No query results for model [App\\Models\\Post] ' . $post->id,
        ];
        $post->delete();    // Assume that the post had been deleted.

        // WHEN
        $reaponse = $this->deleteJson(route('posts.destroy', [
            'post' => $post->id
        ]), $this->headers);

        // THEN
        $reaponse->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
