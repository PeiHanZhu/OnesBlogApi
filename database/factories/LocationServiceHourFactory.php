<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationServiceHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->date();
        $nextDate = Carbon::createFromFormat('Y-m-d', $date)->addDay(1)->format('Y-m-d');
        return [
            'opened_at' => $openedAt = $this->faker->dateTimeBetween($date, $nextDate)->format('Y-m-d H:i'),
            'closed_at' => $this->faker->dateTimeBetween($openedAt, $nextDate)->format('Y-m-d H:i'),
            'weekday' => $this->faker->numberBetween(1, 7),
        ];
    }
}
