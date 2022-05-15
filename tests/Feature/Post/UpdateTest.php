<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var User
     */
    protected $store;

    /**
     * @inheritDoc
     */
    protected function setup(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->store = User::factory()->create([
            'is_store' => 1
        ]);
        $this->post = Post::factory()->create([
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
            'category_id' => 2,
            'title' => '20220510',
        ]);
    }

    public function testUpdate()
    {
        // GIVEN
        $data = [
            'category_id' => 3,
            'title' => 'Update20220510'
        ];

        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->patchJson(route('posts.update', [
            'post' => $this->post->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
