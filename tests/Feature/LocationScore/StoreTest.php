<?php

namespace Tests\Feature\LocationScore;

use App\Models\Location;
use App\Models\LocationScore;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $locationUser;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->locationUser = User::factory()->create();
    }

    public function testWhenLocationScoreCreated()
    {
        // GIVEN
        $location = Location::factory()->for($this->locationUser)->create();
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        $data = [
            'score' => 3.5,
        ];
        $expected = [
            'data' => array_merge($data, [
                'user_id' => $user->id,
                'location_id' => $location->id,
            ]),
        ];

        // WHEN
        $response = $this->postJson(route('location-scores.store', [
            'location' => $location->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
        $this->assertEquals($data['score'], $location->refresh()->avgScore);
    }

    public function testwhenLocationScoreUpdated()
    {
        // GIVEN
        $location = Location::factory()->for($this->locationUser)->create([
            'avgScore' => 2,
        ]);
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        LocationScore::factory()->for($user)->for($location)->create([
            'score' => 2,
        ]);
        $data = [
            'score' => 2.5,
        ];
        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->postJson(route('location-scores.store', [
            'location' => $location->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
        $this->assertEquals($data['score'], $location->refresh()->avgScore);
    }

    public function testWhenLocationScoreDeleted()
    {
        // GIVEN
        $location = Location::factory()->for($this->locationUser)->create();
        $scores = [];
        foreach (range(1, 3) as $i) {
            $user = User::factory()->create();
            LocationScore::factory()->for($user)->for($location)->createQuietly([
                'score' => ($scores[] = rand(1, 5)),
            ]);
        }
        $location->update(['avgScore' => array_sum($scores) / count($scores)]);

        $user = Sanctum::actingAs($user, ['*']);
        $data = [
            'score' => 0,
        ];
        $expected = [
            'data' => $data,
        ];

        // WHEN
        $response = $this->postJson(route('location-scores.store', [
            'location' => $location->id
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_OK)->assertJson($expected);
        array_pop($scores);
        $this->assertEquals(array_sum($scores) / count($scores), $location->refresh()->avgScore);
    }

    public function testWithoutPersonalAccessToken()
    {
        // GIVEN
        $location = Location::factory()->for($this->locationUser)->create();
        $user = User::factory()->create();
        LocationScore::factory()->for($user)->for($location)->create($data = [
            'score' => 3.5,
        ]);
        $expected = [
            'data' => 'Unauthenticated.',
        ];

        // WHEN
        $response = $this->postJson(route('location-scores.store', [
            'location' => $location->id,
        ]), $data, $expected);

        // THEN
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)->assertJson($expected);
    }

    public function testWhenLocationScoreNotFound()
    {
        // GIVEN
        $location = Location::factory()->for($this->locationUser)->create();
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        LocationScore::factory()->for($user)->for($location)->create($data = [
            'score' => 3.5,
        ]);
        $faker = \Faker\Factory::create();
        $locationId = $faker->numberBetween(200, 300);
        $expected = [
            'data' => "Location(ID:{$locationId}) is not found."
        ];

        // WHEN
        $response = $this->postJson(route('location-scores.store', [
            'location' => $locationId
        ]), $data,  $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertJson($expected);
    }

    public function testWhenAnyValidationFailed()
    {
        // GIVEN
        $location = Location::factory()->for($this->locationUser)->create();
        $user = Sanctum::actingAs(User::factory()->create(), ['*']);
        LocationScore::factory()->for($user)->for($location)->create($data = [
            'score' => 6,
        ]);
        $expected = [
            'data' => [
                'score' => [
                    __('validation.between.numeric', [
                        'attribute' => 'score',
                        'min' => 0,
                        'max' => 5,
                    ]),
                ],
            ],
        ];

        // WHEN
        $response = $this->postJson(route('location-scores.store', [
            'location' => $location->id,
        ]), $data, $this->headers);

        // THEN
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)->assertJson($expected);
    }
}
