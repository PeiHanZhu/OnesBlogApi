<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\HTTP\Response;
use Illuminate\Support\Facades\Hash;
use NextApps\VerificationCode\Models\VerificationCode;
use Tests\TestCase;

class VerifyCodeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @inheritDoc
     */
    public function setUp():void
    {
        parent::setUp();

        $this->url = route('auth.verify-code');
    }

    public function testWhenVerificationSucceeded()
    {
        // GIVEN
        $user = User::factory()->create();
        $verification = VerificationCode::create([
            'code' => Hash::make($code = 'ABABA111'),
            'verifiable' => $user->email,
        ]);
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

        // WHEN
        $response = $this->postJson($this->url, $data, $this->headers);

        // THEN
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

        // WHEN
        $response = $this->postJson($this->url, $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
