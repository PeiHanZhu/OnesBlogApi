<?php

namespace Tests\Feature\Location;

use App\Models\CityArea;
use App\Models\Location;
use App\Models\User;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreTest extends TestCase
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

    public function testWhenLocationCreated()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        $data = [
            'user_id' => $user->id,
            'city_area_id' => $this->cityArea->id,
            'category_id' => 2,
            'name' => '巨小機械',
            'address' => '鳳仁街九段243巷701號64樓',
            'phone' => '12345678',
            'avgScore' => '0',
            'introduction' => 'introduction',
        ];

        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->postJson(route('locations.store'), $data, $this->headers);

        //THEN
        $response->assertStatus(Response::HTTP_CREATED)->assertJson($expected);
    }

    public function testWhenLocationCreatedWithImages()
    {
        // GIVEN
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);

        Storage::fake('public');
        $data = [
            'city_area_id' => $this->cityArea->id,
            'category_id' => 2,
            'name' => '巨小機械',
            'address' => '鳳仁街九段243巷701號64樓',
            'phone' => '12345678',
            'images' => [
                $file = UploadedFile::fake()->image('sample.jpg'),
            ],
        ];

        // WHEN
        $response = $this->postJson(route('locations.store'), $data, $this->headers);

        //THEN
        $response->assertStatus(Response::HTTP_CREATED);

        $location = Location::where('user_id', $user->id)->first(['id']);
        Storage::disk('public')->assertExists("/locations/{$location->id}/{$file->hashName()}");
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $user = User::factory()->create();
        $data = [
            'user_id' => $user->id,
            'city_area_id' => $this->cityArea->id,
            'category_id' => 2,
            'name' => '巨小機械',
            'address' => '鳳仁街九段243巷701號64樓',
            'phone' => '12345678',
            'avgScore' => '0',
            'introduction' => 'introduction',
        ];

        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->postJson(route('locations.store'), $data, $this->headers);

        //THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        Sanctum::actingAs( User::factory()->create(), ['*']);

        $expected = [
            'data' => [
                'city_area_id' => [
                    __('validation.required')
                ],
                'category_id' => [
                    __('validation.required')
                ],
                'name' => [
                    __('validation.required')
                ],
                'address' => [
                    __('validation.required')
                ],
                'phone' => [
                    __('validation.required')
                ]
            ]
        ];
        // WHEN
        $response = $this->postJson(route('locations.store'), [], $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
