<?php

namespace Tests\Feature\Comment;

use App\Http\Resources\CommentCollection;
use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testComments()
    {
        // GIVEN
        $comments = collect();
        $locationUser = User::factory()->create();
        $location = Location::factory()->create(['user_id' => $locationUser->id]);
        $postUser = User::factory()->create();
        $post = Post::factory()->for($postUser)->for($location)->create([
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);
        User::factory(5)->create()->each(function($user) use ($comments, $post){
            $comments->push($post->comments()->create($data = [
                'user_id' => $user->id,
                'content' => 'test',
            ]));
        });
        foreach ($comments = (new CommentCollection($comments))->jsonSerialize() as $index => $comment) {
            $comments[$index]['user'] = $comments[$index]['user']->toArray();
            $comments[$index]['post'] = $comments[$index]['post']->toArray();
        }

        $expected = [
            'data' => $comments
        ];

        // WHEN
        $response = $this->getJson(route('comments.index', [
            'post' => $post->id,
        ]));

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
