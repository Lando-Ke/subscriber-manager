<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email_address' => $this->faker->unique()->safeEmail(),
            'state_id' => Arr::random([1,2,3,4,5])
        ];
    }
}
