<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'supplier_id' => \App\Models\Supplier::factory(),
            'cost' => $this->faker->randomFloat(2, 1, 100),
            'status' => $this->faker->randomElement([1]), // 0 for unavailable, 1 for available
        ];
    }
}
