<?php

namespace Database\Seeders;

use App\Models\CityArea;
use App\Models\Comment;
use App\Models\Location;
use App\Models\Post;
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
        User::truncate();
        Post::truncate();
        Comment::truncate();
        Location::truncate();

        $this->call([
            CityAndAreaSeeder::class
        ]);

        $locations = collect();
        $cityAreas = CityArea::all();
        $users = User::factory(30)->create()->map(function ($user) use ($locations, $cityAreas) {
            !boolval(rand(0, 1)) ?: $locations->push(
                Location::factory()->for($cityAreas->random())->create([
                    'user_id' => $user->id,
                ])
            );
            return $user;
        });
        foreach (range(1, 100) as $i) {
            $post = Post::factory()->for($location = $locations->random())
                ->for($users->where('id', '!=', $location->user_id)->random())
                ->create();
            foreach (range(1, 3) as $j) {
                Comment::factory()->for($users->random())->for($post)->create();
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}
