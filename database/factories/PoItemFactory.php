<?php

namespace Database\Factories;

use App\Models\PoItem;
use App\Models\PurchaseOrder;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class PoItemFactory extends Factory
{
    protected $model = PoItem::class;

    public function definition()
    {
        return [
            'po_id' => PurchaseOrder::factory(),
            'item_id' => Item::factory(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'unit' => $this->faker->word,
            'total' => function (array $attributes) {
                return $attributes['quantity'] * $attributes['price'];
            },
        ];
    }
}
