<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BackOrder>
 */
class BackOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receiving_id' => \App\Models\Receiving::factory(), // Assuming you have a Receiving model
            'po_id' => \App\Models\PurchaseOrder::factory(), // Assuming you have a PurchaseOrder model
            'supplier_id' => \App\Models\Supplier::factory(), // Assuming you have a Supplier model
            'bo_code' => $this->faker->unique()->bothify('BO-#####'), // Generates a unique code like BO-12345
            'amount' => $this->faker->randomFloat(2, 100, 10000), // Random amount between 100 and 10,000
            'discount_perc' => $this->faker->randomFloat(2, 0, 50), // Random discount percentage between 0 and 50
            'discount' => $this->faker->randomFloat(2, 0, 1000), // Random discount amount between 0 and 1,000
            'tax_perc' => $this->faker->randomFloat(2, 0, 20), // Random tax percentage between 0 and 20
            'tax' => $this->faker->randomFloat(2, 0, 500), // Random tax amount between 0 and 500
            'remarks' => $this->faker->sentence(), // Random sentence for remarks
            'status' => $this->faker->numberBetween(0, 2), // // 0 = pending, 1 = partially received, 2 =received
        ];
    }
}
