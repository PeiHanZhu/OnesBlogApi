<?php

namespace Tests\Feature\Comment;

use App\Models\Comment;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{

    use RefreshDatabase;

    public function testUpdate()
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
            'title' => '20220510',
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $postUser->id,
            'post_id' => $post->id,
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
}
