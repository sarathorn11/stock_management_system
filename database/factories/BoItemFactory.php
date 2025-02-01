<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoItem>
 */
class BoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => \App\Models\Item::factory(), // Assumes you have an Item model and factory
            'quantity' => $this->faker->numberBetween(1, 100), // Random quantity between 1 and 100
            'price' => $this->faker->randomFloat(2, 10, 1000), // Random price between 10 and 1,000
            'unit' => $this->faker->randomElement(['kg', 'g', 'lb', 'pcs']), // Random unit of measurement
            'total' => function (array $attributes) {
                return $attributes['quantity'] * $attributes['price']; // Calculate total as quantity * price
            },
        ];
    }
}
