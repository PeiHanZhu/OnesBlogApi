<?php

namespace Tests\Feature\Post;

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
        $this->postUser = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $this->post = Post::factory()->create([
            'user_id' => $this->postUser->id,
            'location_id' => $this->location->id,
            'title' => '20220510',
        ]);
    }

    public function testUpdate()
    {
        // GIVEN
        $data = [
            'title' => 'Update20220510'
        ];

        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->putJson(route('posts.update', [
            'post' => $this->post->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
