<?php

namespace Database\Seeders;

use App\Models\CityArea;
use App\Models\Comment;
use App\Models\Location;
use App\Models\LocationLike;
use App\Models\LocationScore;
use App\Models\LocationServiceHour;
use App\Models\Post;
use App\Models\PostKeep;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LocationServiceHour::truncate();
        LocationScore::truncate();
        Comment::truncate();
        Post::truncate();
        Location::truncate();
        User::truncate();
        LocationLike::truncate();
        PostKeep::truncate();

        $this->call([
            CityAndAreaSeeder::class
        ]);

        $locations = collect();
        $cityAreas = CityArea::all();
        $users = User::factory(30)->create()->map(function ($user) use ($locations, $cityAreas) {
            if (boolval(rand(0, 1))) {
                $locations->push(
                    $location = Location::factory()->for($cityAreas->random())->create([
                        'user_id' => $user->id,
                    ])
                );
                foreach (range(1, 3) as $i) {
                    LocationServiceHour::factory()->for($location)->create();
                }
            }
            return $user;
        });

        foreach (range(1, 15) as $i) {
            LocationScore::factory()->for($location = $locations->random())
                ->for($users->where('id', '!=', $location->user_id)->random())
                ->createQuietly();
        }

        $locationAvgScores = LocationScore::selectRaw('AVG(score) as avgScore, location_id')
            ->groupby('location_id')
            ->pluck('avgScore', 'location_id')
            ->toArray();
        Location::whereIn('id', array_keys($locationAvgScores))->get(['id'])
            ->each(function ($location) use ($locationAvgScores) {
                $location->update([
                    'avgScore' => $locationAvgScores[$location->id],
                ]);
            });

        foreach (range(1, 100) as $i) {
            $post = Post::factory()->for($location = $locations->random())
                ->for($users->where('id', '!=', $location->user_id)->random())
                ->create();
            foreach (range(1, 3) as $j) {
                Comment::factory()->for($users->random())->for($post)->create();
            }
        }

        foreach (range(1, 10) as $i) {
            $user = User::inRandomOrder()->first();
            $location = Location::inRandomOrder()->first();
            $post = Post::inRandomOrder()->first();
            LocationLike::factory()->for($user)->for($location)->create();
            PostKeep::factory()->for($user)->for($post)->create();
        }
        Schema::enableForeignKeyConstraints();
    }
}
