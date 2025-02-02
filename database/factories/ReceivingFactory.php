<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Receiving>
 */
class ReceivingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_id' => $this->faker->numberBetween(1, 100), // Random ID for PO or BO
            'from_order' => $this->faker->randomElement([1, 2]), // Random value (1 = PO, 2 = BO)
            'amount' => $this->faker->randomFloat(2, 100, 10000), // Random amount between 100 and 10,000
            'discount_perc' => $this->faker->randomFloat(2, 0, 50), // Random discount percentage between 0 and 50
            'discount' => $this->faker->randomFloat(2, 0, 1000), // Random discount amount between 0 and 1,000
            'tax_perc' => $this->faker->randomFloat(2, 0, 20), // Random tax percentage between 0 and 20
            'tax' => $this->faker->randomFloat(2, 0, 500), // Random tax amount between 0 and 500
            'stock_ids' => json_encode([$this->faker->numberBetween(1, 100), $this->faker->numberBetween(1, 100)]), // JSON array of stock IDs
            'remarks' => $this->faker->sentence(), // Random sentence for remarks
        ];
    }
}
