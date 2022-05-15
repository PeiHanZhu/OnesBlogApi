<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Post;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $post = Post::inRandomOrder()->first() ?? Post::factory()->create();

        return [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $this->faker->text,
        ];
    }
}
