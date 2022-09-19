<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\HTTP\Response;
use NextApps\VerificationCode\Models\VerificationCode;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class VerifyCodeTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenVerificationSucceeded()
    {
        // GIVEN
        $user = User::factory()->create();
        $verification = VerificationCode::create([
            'code' => Hash::make($code = 'ABABA111'),
            'verifiable' => $user->email,
        ]);

        // WHEN
        $data = [
            'code' => $code,
            'email' => $verification->verifiable,
        ];
        $expected = [
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ];

        // THEN
        $response = $this->postJson(route('auth.verifyCode'), $data, $this->headers);

        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenVerificationFailed()
    {
        // GIVEN
        $user = User::factory()->create();
        $verification = VerificationCode::create([
            'code' => Hash::make($code = 'ABABA111'),
            'verifiable' => $user->email,
        ]);

        // WHEN
        $data = [
            'code' => 'AAAA111',
            'email' => $verification->verifiable,
        ];
        $expected = [
            'data' => [
                'email' => [
                    'The code is incorrect.',
                ],
            ],
        ];

        // THEN
        $response = $this->postJson(route('auth.verifyCode'), $data, $this->headers);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
