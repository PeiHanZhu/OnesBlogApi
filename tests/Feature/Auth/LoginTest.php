<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->url = route('auth.login');
    }

    public function testWhenLoginSucceeded()
    {
        // GIVEN
        $user = User::factory()->create([
            'email' => 'saber@gmail.com',
            'password' => Hash::make($password = '123456'),
        ]);
        $data = [
            'email' => $user->email,
            'password' => $password,
            'device_name' => 'iPhone',
        ];
        $expected = [
            'data' => array_diff_key(
                $data,
                array_flip([
                    'password',
                    'device_name',
                ]),
            )
        ];

        // WHEN
        $response = $this->postJson($this->url, $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        $data = [];

        $expected = [
            'data' => [
                'email' => [
                    __('validation.required')
                ],
                'password' => [
                    __('validation.required')
                ],
                'device_name' => [
                    __('validation.required')
                ],
            ],
        ];

        // WHEN
        $response = $this->postJson($this->url, $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }

    public function testWhenCredentialsNotMatch()
    {
        // GIVEN
        $user = User::factory()->create([
            'email' => 'saber@gmail.com',
            'password' => '123456',
        ]);
        $data = [
            'email' => $user->email,
            'password' => '123456789',
            'device_name' => 'iPhone',
        ];

        $expected = [
            'data' => [
                'email' => [
                    __('auth.failed')
                ],
            ],
        ];

        // WHEN
        $response = $this->postJson($this->url, $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
