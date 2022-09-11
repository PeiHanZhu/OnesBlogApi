<?php

namespace Tests\Feature\Location;

use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var CityArea
     */
    protected $cityArea;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CityAndAreaSeeder::class);
        $this->cityArea = CityArea::inRandomOrder()->first();
    }

    public function testWhenLocationUpdated()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create());
        $location = Location::factory()->create([
            'user_id' => $user->id,
            'city_area_id' => $this->cityArea->id,
            'name' => '新亞洲汽車',
        ]);
        $data = [
            'name' => '美利達汽車',
        ];

        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->putJson(route('locations.update', [
            'location' => $location->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $user = User::factory()->create();
        $location = Location::factory()->create([
            'user_id' => $user->id,
            'city_area_id' => $this->cityArea->id,
            'name' => '新亞洲汽車',
        ]);
        $data = [
            'name' => '美利達汽車',
        ];

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->putJson(route('locations.update', [
            'location' => $location->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenLocationUpdatedByWrongUser()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create());
        $locationUser = User::factory()->create();
        $location = Location::factory()->create([
            'user_id' => $locationUser->id,
            'city_area_id' => $this->cityArea->id,
            'name' => '新亞洲汽車',
        ]);
        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->putJson(route('locations.update', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenLocationNotFound()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create());
        $faker = \Faker\Factory::create();
        $locationId = $faker->numberBetween(100, 300);

        $expected = [
            'data' => "Location(ID:{$locationId}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('locations.show', [
            'location' => $locationId,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
