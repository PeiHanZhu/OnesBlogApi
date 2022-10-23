<?php

namespace Tests\Feature\Auth;

use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use NextApps\VerificationCode\Support\CodeGenerator;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenPasswordSuccessfullyReset()
    {
        // GIVEN
        $user = User::factory()->create([
            'email' => 'test@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
        ]);
        $resetCodePassword = ResetCodePassword::create([
            'email' => $user->email,
            'code' => Hash::make(app(CodeGenerator::class)->generate()),
        ]);
        $data = [
            'email' => $user->email,
            'code' => $resetCodePassword->code,
            'password' => $password = '654321',
        ];

        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->postJson(route('auth.reset-password'), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
        $this->assertTrue(Hash::check($password, $user->refresh()->password));
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        User::factory()->create([
            'email' => 'test@gmail.com',
            'email_verified_at' => now(),
        ]);
        $data = [];

        $expected = [
            'data' => [
                'email' => [
                    __('validation.required')
                ],
                'code' => [
                    __('validation.required')
                ],
                'password' => [
                    __('validation.required')
                ]
            ]
        ];

        // WHEN
        $response = $this->postJson(route('auth.reset-password'), $data, $this->headers);

        // TEHN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
