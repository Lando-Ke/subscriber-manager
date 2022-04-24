<?php

namespace Database\Factories;

use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscriber_id' => Subscriber::factory(),
            'title' => $this->faker->word(),
            'type' => $this->faker->randomElement(['string', 'boolean', 'number', 'date']),
            'value' => $this->faker->word()
        ];
    }
}
