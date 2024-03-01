<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site' => $this->faker->word,
            'equipment_name' => $this->faker->word,
            'inventory_number' => $this->faker->word,
            'node' => $this->faker->word,
            'component' => $this->faker->word,
            'vendor_code' => $this->faker->word,
            'operation' => $this->faker->word,
            'service_period_in_days' => $this->faker->numberBetween(1, 365),
            'service_period_in_engine_hours' => $this->faker->numberBetween(1, 1000),
            'mileage' => $this->faker->numberBetween(1000, 100000),
            'amount' => $this->faker->numberBetween(1, 100),
        ];
    }
}
