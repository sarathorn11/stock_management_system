<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sales_code' => $this->faker->unique()->bothify('SALE-#####'), // Generates a unique sales code like SALE-12345
            'client' => $this->faker->name(), // Generates a random client name
            'amount' => $this->faker->randomFloat(2, 100, 10000), // Random amount between 100 and 10,000
            'stock_id' => \App\Models\Stock::factory(), // Assumes you have a Stock model and factory
            'remarks' => $this->faker->sentence(), // Random sentence for remarks
        ];
    }
}
