<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
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

        User::factory(5)->create();
        Post::factory(100)->create();
        Comment::factory(20)->create();

        Schema::enableForeignKeyConstraints();
    }
}
