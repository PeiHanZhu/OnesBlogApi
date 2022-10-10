<?php

namespace Database\Factories;

use App\Enums\LocationCategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;


class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(
                min($categoryIds = LocationCategoryEnum::getAllCategoryValues()),
                max($categoryIds)
            ),
            'name' => $this->faker->company(),
            'address' => $this->faker->streetAddress(),
            'phone' => $this->faker->numerify('##########'),
            'avgScore' => 0,
            'introduction' => $this->faker->text,
        ];
    }
}
