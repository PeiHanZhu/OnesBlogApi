<?php

namespace Tests\Feature\User;

use App\Enums\UserLoginTypeIdEnum;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testWhenUserInformationUpdated()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create([
            'name' => 'Amy',
            'email' => 'amy@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $data = [
            'name' => 'Julia',
            'password' => Hash::make('1234567890'),
        ];
        $data = array_merge(array_diff_key($data, array_flip([
            'password',
        ])), ['email' => $user->email]);

        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->putJson(route('users.update', [
            'user' => $user->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        $user = User::factory()->create([
            'name' => 'Amy',
            'email' => 'amy@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $data = [
            'name' => 'Julia',
            'password' => Hash::make('1234567890'),
        ];
        $data = array_merge(array_diff_key($data, array_flip([
            'password',
        ])), ['email' => $user->email]);

        $expected = [
            'data' => 'Unauthenticated.'
        ];

        // WHEN
        $response = $this->putJson(route('users.update', [
            'user' => $user->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);

    }

    public function testWhenUserNotFound()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $faker = \Faker\Factory::create();
        $userId = $faker->numberBetween(100, 300);
        $data = [
            'name' => 'Julia',
        ];

        $expected = [
            'data' => "User(ID:{$userId}) is not found.",
        ];

        // WHEN
        $response = $this->putJson(route('users.update', [
            'user' => $userId,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenUserWithLocationSwitchAccount()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create([
            'name' => 'Amy',
            'email' => 'amy@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        Location::factory()->for($user)->create([
            'active' => 1,
        ]);
        $data = [
            'login_type_id' => UserLoginTypeIdEnum::LOCATION,
        ];

        $expected = [
            'data' => $data = (array_merge($data, ['email' => $user->email], ['name' => $user->name])),
        ];

        // WHEN
        $response = $this->putJson(route('users.update', [
            'user' => $user->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenUserWithoutLocationSwitchAccount()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create([
            'name' => 'Amy',
            'email' => 'amy@gmail.com',
            'password' => Hash::make('123456'),
        ]), ['*']);
        $data = [
            'login_type_id' => UserLoginTypeIdEnum::LOCATION
        ];
        $expected = [
            'data' => [
                'email' => __('auth.none_location_user'),
            ],
        ];

        // WHEN
        $response = $this->putJson(route('users.update', [
            'user' => $user->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
