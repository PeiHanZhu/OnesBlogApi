<?php

namespace Tests\Feature\Post;

use App\Models\Location;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
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
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->locationUser = User::factory()->create();
        $this->location = Location::factory()->for($this->locationUser)->create();
        $this->postUser = User::factory()->create();
    }

    public function testIndexQueriedByCategoryId()
    {
        // GIVEN
        $post = Post::factory()->create($data = [
            'user_id' => $this->postUser->id,
            'location_id' => $this->location->id,
            'published_at' => now()->toDateString(),
            'active' => 1,
        ]);

        $data = array_diff_key($data, array_flip([
            'user_id',
            'active',
        ]));
        $expected = [
            'data' => [
                array_merge(
                    $data,
                    ['user' => ['id' => $this->postUser->id]]
                ),
            ],
        ];

        // WHEN
        $response = $this->getJson(route('posts.index') . '?' . http_build_query([
            'category_id' => $post->location->category_id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
