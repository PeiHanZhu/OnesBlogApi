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

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenPostUpdated()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($location)->create([
            'title' => '20220510',
        ]);
        $data = [
            'title' => 'Update20220510'
        ];

        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->putJson(route('posts.update', [
            'post' => $post->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenPostUpdatedWithImages()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $post = Post::factory()->for($postUser)->for($location)->create([
            'title' => '20220510',
        ]);
        Storage::fake('public');
        $data = [
            '_method' => 'PUT',
            'images' => [
                $file = UploadedFile::fake()->image('sample.jpg'),
            ],
        ];

        // WHEN
        $response = $this->postJson(route('posts.update', [
            'post' => $post->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK);
        Storage::disk('public')->assertExists("/posts/{$post->id}/{$file->hashName()}");
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create([
            'title' => 'test',
        ]);
        $data = [
            'title' => 'Update20220928'
        ];

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->putJson(route('posts.update', [
            'post' => $post->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenPostUpdatedByWrongUser()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->create($data = []);
        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->putJson(route('posts.update', [
            'post' => $post->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenPostNotFound()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $faker = \Faker\Factory::create();
        $postId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "Post(ID:{$postId}) is not found.",
        ];

        // WHEN
        $response = $this->putJson(route('posts.update', [
            'post' => $postId
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
