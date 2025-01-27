<?php

namespace Database\Factories;

use App\Models\BackOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class BackOrderFactory extends Factory
{
    protected $model = BackOrder::class;

    public function definition()
    {
        return [
            'receiving_id' => \App\Models\Receiving::factory(),
            'po_id' => \App\Models\PurchaseOrder::factory(),
            'supplier_id' => \App\Models\Supplier::factory(),
            'bo_code' => $this->faker->unique()->numerify('BO###'),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'discount_perc' => $this->faker->numberBetween(0, 30),
            'discount' => $this->faker->randomFloat(2, 0, 300),
            'tax_perc' => $this->faker->numberBetween(0, 20),
            'tax' => $this->faker->randomFloat(2, 0, 200),
            'remarks' => $this->faker->sentence(),
            'status' => $this->faker->numberBetween(0, 2), // 0 = pending, 1 = partially received, 2 =received
        ];
    }
}
