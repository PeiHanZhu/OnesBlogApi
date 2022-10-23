<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use NextApps\VerificationCode\Models\VerificationCode;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ResendVerificationCodeTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenVerificationCodeSuccessfullyResended()
    {
        // GIVEN
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
        $verification = VerificationCode::create([
            'code' => Hash::make('ABABA111'),
            'verifiable' => $user->email,
        ]);
        $data = [
            'email' => $verification->verifiable,
        ];

        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->postJson(route('auth.resend-verification-code'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenVerificationFailed()
    {
        User::factory()->create([
            'email_verified_at' => null,
        ]);
        $data = [];

        $expected = [
            'data' => [
                'email' => [
                    __('validation.required'),
                ]
            ],
        ];

        // WHEN
        $response = $this->postJson(route('auth.resend-verification-code'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
