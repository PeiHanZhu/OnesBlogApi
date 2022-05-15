<?php

namespace Tests\Feature\Post;

use App\Enums\PostCategoryEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class IndexTest extends TestCase
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
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->store = User::factory()->create([
            'is_store' => 1,
        ]);
    }

    public function testIndexQueriedByCategoryId()
    {
        // GIVEN
        Post::factory()->create($data = [
            'user_id' => $this->user->id,
            'store_id' => $this->store->id,
            'category_id' => ($categoryId = PostCategoryEnum::RESTAURANTS),
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
                    ['user' => ['id' => $this->user->id]]
                ),
            ],
        ];

        // WHEN
        $response = $this->getJson(route('posts.index') . '?' . http_build_query([
            'category_id' => $categoryId,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
