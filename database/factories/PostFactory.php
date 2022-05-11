<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'store_id' => $this->faker->numberBetween(1, 5),
            'category_id' => $this->faker->numberBetween(1, 3),
            'title' => $this->faker->text,
            'content' => $this->faker->text,
            'published_at' => $this->faker->dateTimeThisMonth,
            'active' => $this->faker->boolean,
            'slug' => $this->faker->text,
        ];
    }
}
