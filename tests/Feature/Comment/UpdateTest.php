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

class UpdateTest extends TestCase
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

    public function testWhenCommentUpdated()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);

        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'title' => '20220510',
        ]);
        $comment = Comment::factory()->for($postUser)->for($post)->create([
            'content' => '0513',
        ]);
        $data = [
            'content' => 'update0513'
        ];
        $expected = [
            'data' => $data
        ];

        // WHEN
        $response = $this->putJson(route('comments.update', [
            'post' => $post->id,
            'comment' => $comment->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenCommentUpdatedWithImages()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'title' => '20220510',
        ]);
        Storage::fake('public');
        $comment = Comment::factory()->for($postUser)->for($post)->create();
        $data = [
            'content' => 'test',
            '_method' => 'PUT',
            'images' => [
                $file = UploadedFile::fake()->image('sample.jpg'),
            ],
        ];

        // WHEN
        $response = $this->postJson(route('comments.update', [
            'post' => $post->id,
            'comment' => $comment->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK);
        Storage::disk('public')->assertExists("/comments/{$comment->id}/{$file->hashName()}");
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'title' => '20220510',
        ]);
        $comment = Comment::factory()->for($postUser)->for($post)->create([
            'content' => 'test',
        ]);
        $data = [
            'content' => 'test0928',
        ];
        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->putJson(route('comments.update', [
            'post' => $post->id,
            'comment' => $comment->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenCommentUpdatedByWrongUser()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'title' => '20220510',
        ]);
        $comment = Comment::factory()->for($postUser)->for($post)->create([
            'content' => 'test',
        ]);
        $data = [
            'content' => 'test0928',
        ];
        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->putJson(route('comments.update', [
            'post' => $post->id,
            'comment' => $comment->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenCommentNotFound()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($this->location)->create([
            'title' => '20220510',
        ]);
        $faker = \Faker\Factory::create();
        $commentId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "Comment(ID:{$commentId}) is not found.",
        ];

        // WHEN
        $response = $this->putJson(route('comments.update', [
            'post' => $post->id,
            'comment' => $commentId,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
