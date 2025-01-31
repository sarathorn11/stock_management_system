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
            'name' => $this->faker->word(), // Generates a random word for the item name
            'description' => $this->faker->sentence(), // Generates a random sentence for the description
            'supplier_id' => \App\Models\Supplier::factory(), // Assumes you have a Supplier model and factory
            'cost' => $this->faker->randomFloat(2, 10, 1000), // Random cost between 10 and 1,000
            'status' => $this->faker->randomElement([1]), // Random status (0 or 1)
        ];
    }
}
