<?php

namespace Tests\Feature\Post;

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

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Location
     */
    protected $location;

    /**
     *  @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->locationUser = User::factory()->create();
        $this->location = Location::factory()->for($this->locationUser)->create();
        $this->postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
    }

    public function testDestroy()
    {
        // GIVEN
        $post = Post::factory()->create([
            'user_id' => $this->postUser->id,
            'location_id' => $this->location->id,
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
            'user_id' => $this->postUser->id,
            'location_id' => $this->location->id,
            'title' => 'Test',
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
