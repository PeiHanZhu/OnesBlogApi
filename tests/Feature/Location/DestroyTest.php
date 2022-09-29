<?php

namespace Tests\Feature\Location;

use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DestroyTest extends TestCase
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

    public function testWhenLocationDeleted()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($user)->for($this->cityArea)->create();

        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }

    public function testWhenLocationDeletedWithImages()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        Storage::fake('public');
        $location = Location::factory()->for($user)->for($this->cityArea)->create();
        $location->update([
            'images' => [
                $filePath = UploadedFile::fake()->image('sample.jpg')
                    ->store("/locations/{$location->id}", 'public'),
            ],
        ]);

        $expected = [
            'data' => 'Success',
        ];

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
        Storage::disk('public')->assertMissing($filePath);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $user = User::factory()->create();
        $location = Location::factory()->for($user)->for($this->cityArea)->create();

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenLocationDeletedByWrongUser()
    {
        // GIVEN
        Sanctum::actingAs(User::factory()->create(), ['*']);
        $locationUser = User::factory()->create();
        $location = Location::factory()->for($locationUser)->for($this->cityArea)->create();

        $expected = [
            'data' => 'This action is unauthorized.',
        ];

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_FORBIDDEN)->assertJson($expected);
    }

    public function testWhenLocationNotFound()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        $location = Location::factory()->for($user)->for($this->cityArea)->create();

        $expected = [
            'data' => "Location(ID:{$location->id}) is not found.",
        ];
        $location->delete(); // Assume that the location had been deleted.

        // WHEN
        $response = $this->deleteJson(route('locations.destroy', [
            'location' => $location->id,
        ]), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }
}
