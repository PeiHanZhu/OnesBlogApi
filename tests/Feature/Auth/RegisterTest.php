<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->url = route('auth.register');
    }

    public function testWhenRegisterationSucceeded()
    {
        // GIVEN
        $data = [
            'name' => 'XUN',
            'email' => 'test@gmail.com',
            'password' => '123456',
            'device_name' => 'iPhone',
        ];

        $expected = [
            'data' => array_diff_key(
                $data,
                array_flip([
                    'device_name',
                    'password',
                ])
            ),
        ];

        // WHEN
        $response = $this->postJson($this->url, $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        $data = [];

        $expected = [
            'data' => [
                'name' => [
                    __('validation.required')
                ],
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
}
