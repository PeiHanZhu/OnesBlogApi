<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenEmailSuccessfullySended()
    {
        // GIVEN
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $data = [
            'email' => $user->email,
        ];

        $expected = [
            'data' => 'Success'
        ];

        // WHEN
        $response = $this->postJson(route('auth.forgot-password'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenEmailWithoutVerified()
    {
        // GIVEN
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $data = [
            'email' => $user->email,
        ];

        $expected = [
            'data' => [
                'email' => __('auth.failed')
            ]
        ];

        // WHEN
        $response = $this->postJson(route('auth.forgot-password'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $data = [];

        $expected = [
            'data' => [
                'email' => [
                    __('validation.required')
                ]
            ]
        ];

        // WHEN
        $response = $this->postJson(route('auth.forgot-password'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
