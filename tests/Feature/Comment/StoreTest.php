<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
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

class StoreTest extends TestCase
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

        $this->locationUser = User::factory()->create();
        $this->location = Location::factory()->for($this->locationUser)->create();
    }

    public function testWhenCommentCreated()
    {
        // GIVEN
        /** @var \Illuminate\Database\Eloquent\Model */
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $data = [
            'user_id' => $postUser->id,
            'post_id' => $post->id,
            'content' => 'XUN',
        ];
        $expected = [
            'data' => [
                'user' => $postUser->toArray(),
                'post' => $post->toArray(),
                'content' => 'XUN',
            ],
        ];

        // WHEN
        $response = $this->postJson(route('comments.store', [
            'post' => $post->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }

    public function testWhenCommentCreatedWithImages()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        Storage::fake('public');
        $data = [
            'user_id' => $postUser->id,
            'post_id' => $post->id,
            'content' => 'XUN',
            'images' => [
                $file = UploadedFile::fake()->image('sample.jpg')
            ],
        ];

        // WHEN
        $response = $this->postJson(route('comments.store', [
            'post' => $post->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED);
        $comment = Comment::where('user_id', $postUser->id)->first(['id']);
        Storage::disk('public')->assertExists("/comments/{$comment->id}/{$file->hashName()}");
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $data = [
            'user_id' => $postUser->id,
            'post_id' => $post->id,
            'content' => 'XUN',
        ];

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->postJson(route('comments.store', [
            'post' => $post->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }
}
