<?php

namespace Tests\Feature\Post;

use App\Enums\PostCategoryEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     *  @var Store
     */
    protected $store;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $this->store = User::factory()->create([
            'is_store' => 1,
        ]);
    }

    public function testStore()
    {
        // GIVEN
        $data = [
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
            'category_id' => PostCategoryEnum::RESTAURANTS,
            'title' => 'Test',
            'content' => 'Hello, everyone.',
            'published_at' => now()->toDateString(),
        ];

        $expected = [
            'data' => array_merge(
                array_diff_key($data, array_flip([
                    'user_id',
                ])),
                ['user' => ['id' => $this->user->id]]
            ),
        ];

        // WHEN
        $response = $this->postJson(route('posts.store'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }
}
