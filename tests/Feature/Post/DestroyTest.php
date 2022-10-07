<?php

namespace Tests\Feature\Post;

use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
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
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->locationUser = User::factory()->create();
        $this->location = Location::factory()->for($this->locationUser)->create();
    }

    public function testWhenPostDeleted()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
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

    public function testWhenPostDeletedWithImages()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now(),
            'active' => 1,
        ]);
        $post->update([
            'images' => [
                $filePath = UploadedFile::fake()->image('sample.jpg')
                    ->store("/posts/{$post->id}", 'public'),
            ],
        ]);

        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->deleteJson(route('posts.destroy', [
            'post' => $post->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
        Storage::disk('public')->assertMissing($filePath);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now(),
            'active' => 1,
        ]);

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->deleteJson(route('posts.destroy', [
            'post' => $post->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenPostDeletedByWrongUser()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now(),
            'active' => 1,
        ]);

        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->deleteJson(route('posts.destroy', [
            'post' => $post->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenPostNotFound()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
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
