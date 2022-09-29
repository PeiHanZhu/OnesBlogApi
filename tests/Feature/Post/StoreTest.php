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

    public function testWhenPostCreated()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $data = [
            'user_id' => $postUser->id,
            'location_id' => $this->location->id,
            'title' => 'Test',
            'content' => 'Hello, everyone.',
            'published_at' => now()->toDateString(),
        ];

        $expected = [
            'data' => array_merge(
                array_diff_key($data, array_flip([
                    'user_id',
                ])),
                ['user' => ['id' => $postUser->id]]
            ),
        ];

        // WHEN
        $response = $this->postJson(route('posts.store'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }

    public function testWhenPostCreatedWithImages()
    {
        // GIVEN
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        Storage::fake('public');
        $data = [
            'user_id' => $postUser->id,
            'location_id' => $this->location->id,
            'title' => 'Test',
            'content' => 'Hello, everyone.',
            'published_at' => now()->toDateString(),
            'images' => [
                $file = UploadedFile::fake()->image('sample.jpg'),
            ],
        ];

        // WHEN
        $response = $this->postJson(route('posts.store'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED);
        $post = Post::where('user_id', $postUser->id)->first(['id']);
        Storage::disk('public')->assertExists("/posts/{$post->id}/{$file->hashName()}");
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'location_id' => $this->location->id,
            'title' => 'Test',
        ];
        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->postJson(route('posts.store'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }
}
