<?php

namespace Tests\Feature\City;

use App\Http\Resources\CityCollection;
use App\Models\City;
use Database\Seeders\CityAndAreaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testCities()
    {
        // GIVEN
        $this->seed(CityAndAreaSeeder::class);

        $expected = [
            'data' => (new CityCollection(City::all()))->jsonSerialize(),
        ];

        // WHEN
        $response = $this->getJson(route('cities.index'), $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
    }
}
