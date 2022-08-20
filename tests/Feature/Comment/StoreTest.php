<?php

namespace Tests\Feature\Comment;

use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        // GIVEN
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->create();
        $postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);

        $post = Post::factory()->create([
            'user_id' => $postUser->id,
            'location_id' => $location->id,
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        $expected = [
            'data' => $data = [
                'user_id' => $postUser->id,
                'post_id' => $post->id,
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
}
