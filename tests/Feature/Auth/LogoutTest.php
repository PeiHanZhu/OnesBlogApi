<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->url = route('auth.logout');
    }

    public function testWhenLogoutSucceeded()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create([
            'name' => 'GUO_XUN',
            'email' => 'saber@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);

        $data = [
            'device_name' => 'iPhone',
        ];

        $expected = [
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => '',
            ],
        ];

        // WHEN
        $response = $this->post($this->url, $data ,$this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $data = [
            'device_name' => 'iPhone',
        ];

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->postJson($this->url, $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }
}
