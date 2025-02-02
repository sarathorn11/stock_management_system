<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReturnList>
 */
class ReturnListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'return_code' => $this->faker->unique()->bothify('R-#####'), // Generates a unique return code like R-12345
            'supplier_id' => \App\Models\Supplier::factory(), // Assumes you have a Supplier model and factory
            'stock_id' => \App\Models\Stock::factory(), // Assumes you have a Stock model and factory
            'amount' => $this->faker->randomFloat(2, 100, 10000), // Random amount between 100 and 10,000
            'remarks' => $this->faker->sentence(), // Random sentence for remarks
        ];
    }
}
