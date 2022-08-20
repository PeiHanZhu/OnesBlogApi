<?php

namespace Tests\Feature\Post;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

    /**
     *  @var Location
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
        $this->postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
    }

    public function testStore()
    {
        // GIVEN
        $data = [
            'user_id' => $this->postUser->id,
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
                ['user' => ['id' => $this->postUser->id]]
            ),
        ];

        // WHEN
        $response = $this->postJson(route('posts.store'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }
}
