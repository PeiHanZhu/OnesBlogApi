<?php

namespace Database\Factories;

use App\Enums\PostCategoryEnum;
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
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $store = User::where([
            ['id', '!=', $user->id],
            ['is_store', 1]
        ])->first() ?? User::factory()->create([
            'is_store' => 1,
        ]);

        return [
            'user_id' => $user->id,
            'store_id' => $store->id,
            'category_id' => $this->faker->numberBetween(
                min($categoryIds = PostCategoryEnum::getAllCategoryValues()),
                max($categoryIds)
            ),
            'title' => $this->faker->text,
            'content' => $this->faker->text,
            'published_at' => $this->faker->dateTimeThisMonth,
            'active' => $this->faker->boolean,
            'slug' => $this->faker->text,
        ];
    }
}
