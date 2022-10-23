<?php

namespace Tests\Feature\Location;

use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShowTest extends TestCase
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

    public function testWhenLocationDisplayed()
    {
        // GIVEN
        $user = User::factory()->create();
        $location = Location::factory()->create($data = [
            'user_id' => $user->id,
            'city_area_id' => $this->cityArea->id,
            'active' => 1,
        ]);

        $expected = [
            'data' => array_diff_key(
                $data,
                array_flip([
                    'active'
                ]),
            )
        ];

        // WHEN
        $response = $this->getJson(route('locations.show', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenLocationUnverified()
    {
        // GIVEN
        $user = User::factory()->create();
        $location = Location::factory()->for($user)->create([
            'active' => 0,
        ]);

        $expected = [
            'data' => "Location(ID:{$location->id}) is not found.",
        ];

        // WHEN
        $response = $this->getJson(route('locations.show', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenLocationNotFound()
    {
        // GIVEN
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
