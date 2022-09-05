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

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $user;

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

        $this->user = Sanctum::actingAs(User::factory()->create(), ['*']);
        $this->seed(CityAndAreaSeeder::class);
        $this->cityArea = CityArea::inrandomOrder()->first();
    }

    public function testWhenLocationDelete()
    {
        // GIVEN
        $location = Location::factory()->create([
            'user_id' => $this->user->id,
            'city_area_id' => $this->cityArea->id,
        ]);

        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
    public function testWhenLocationNotFound()
    {
        // GIVEN
        $location = Location::factory()->create([
            'user_id' => $this->user->id,
            'city_area_id' => $this->cityArea->id,
        ]);

        $expected = [
            'data' => "Location(ID:{$location->id}) is not found."
        ];
        $location->delete(); // Assume that the location had been deleted.

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenLocationDeletedByWrongUser()
    {
        // GIVEN
        $deletedUser = User::factory()->create();
        $location = Location::factory()->create([
            'user_id' => $deletedUser->id,
            'city_area_id' => $this->cityArea->id,
        ]);

        $expected = [
            'data' => 'This action is unauthorized.'
        ];

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }
}
