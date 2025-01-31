<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'po_code' => $this->faker->unique()->bothify('PO-#####'), // Generates a unique code like PO-12345
            'supplier_id' => \App\Models\Supplier::factory(), // Assumes you have a Supplier model and factory
            'amount' => $this->faker->randomFloat(2, 100, 10000), // Random amount between 100 and 10,000
            'discount_perc' => $this->faker->randomFloat(2, 0, 50), // Random discount percentage between 0 and 50
            'discount' => $this->faker->randomFloat(2, 0, 1000), // Random discount amount between 0 and 1,000
            'tax_perc' => $this->faker->randomFloat(2, 0, 20), // Random tax percentage between 0 and 20
            'tax' => $this->faker->randomFloat(2, 0, 500), // Random tax amount between 0 and 500
            'remarks' => $this->faker->sentence(), // Random sentence for remarks
            'status' => $this->faker->numberBetween(0, 2), // Random status (0 = pending, 1 = partially received, 2 = received)
        ];
    }
}
