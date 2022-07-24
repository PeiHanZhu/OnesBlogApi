<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

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
     *  @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
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
            'data' => "Post(ID:{$post->id}) is not found.",
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
