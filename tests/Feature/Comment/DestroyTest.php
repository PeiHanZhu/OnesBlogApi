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

    public function testWhenCommentDeleted()
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
        $comment = Comment::factory()->for($postUser)->for($post)->create([
            'content' => 'test',
        ]);

        $expected = [
            'data' => 'Success'
        ];

        // WHEN
        $response = $this->deleteJson(route('comments.destroy', [
            'post' => $post->id,
            'comment' => $comment->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenCommentDeletedWithImages()
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
        $comment = Comment::factory()->for($postUser)->for($post)->create(['content' => 'test']);
        $this->location->update([
            'images' => [
                $filePath = UploadedFile::fake()->image('sample.jpg')
                    ->store("/comments/{$comment->id}", 'public'),
            ],
        ]);

        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->deleteJson(route('comments.destroy', [
            'post' => $post->id,
            'comment' => $comment->id,
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
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $comment = Comment::factory()->for($postUser)->for($post)->create($data = [
            'content' => 'test',
        ]);

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->deleteJson(route('comments.destroy', [
            'post' => $post->id,
            'comment' => $comment->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenCommentDeletedByWrongUser()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $comment = Comment::factory()->for($postUser)->for($post)->create(['content' => 'test']);

        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->deleteJson(route('comments.destroy', [
            'post' => $post->id,
            'comment' => $comment->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenCommentNotFound()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create(), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $comment = Comment::factory()->for($postUser)->for($post)->create([
            'content' => 'test',
        ]);
        $expected = [
            'data' => "Comment(ID:{$comment->id}) is not found.",
        ];
        $comment->delete(); // Assume that the comment had been deleted.

        // WHEN
        $response = $this->deleteJson(route('comments.destroy', [
            'post' => $post->id,
            'comment' => $comment->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
