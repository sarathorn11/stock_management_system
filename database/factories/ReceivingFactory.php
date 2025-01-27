<?php

namespace Database\Factories;

use App\Models\Receiving;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceivingFactory extends Factory
{
    protected $model = Receiving::class;

    public function definition()
    {
        return [
            'from_id' => $this->faker->numberBetween(1, 100),
            'from_order' => $this->faker->randomElement([1, 2]),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'discount_perc' => $this->faker->randomFloat(2, 0, 100),
            'discount' => $this->faker->randomFloat(2, 0, 100),
            'tax_perc' => $this->faker->randomFloat(2, 0, 100),
            'tax' => $this->faker->randomFloat(2, 0, 100),
            'stock_ids' => $this->faker->text,
            'remarks' => $this->faker->sentence,
        ];
    }
}
