<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CheckCodeTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenVerificationFailed()
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
                ],
                'code' => [
                    __('validation.required')
                ]
            ]
        ];

        // WHEN
        $response = $this->postJson(route('auth.check-code'), $data, $this->headers);

        // THEM
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
