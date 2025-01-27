<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    protected $model = PurchaseOrder::class;

    public function definition()
    {
        return [
            'po_code' => $this->faker->unique()->numerify('PO#####'),
            'supplier_id' => \App\Models\Supplier::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 10000),
            'discount_perc' => $this->faker->numberBetween(0, 30),
            'discount' => $this->faker->randomFloat(2, 0, 3000),
            'tax_perc' => $this->faker->numberBetween(0, 20),
            'tax' => $this->faker->randomFloat(2, 0, 2000),
            'remarks' => $this->faker->sentence,
            'status' => $this->faker->numberBetween(0, 2), // 0 = pending, 1 = partially received, 2 = received
        ];
    }
}
