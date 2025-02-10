<?php

namespace Database\Seeders;

use App\Models\PoItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 purchase order items using the PoItemFactory
        // PoItem::factory()->count(10)->create();

        // Create 20 po items manually
        for ($i = 1; $i <= 20; $i++) {
            $quantity = rand(1, 100);
            $price = rand(10, 1000);
            PoItem::create([
                'po_id' => rand(1, 10),
                'item_id' => rand(1, 20),
                'quantity' => $quantity,
                'price' => $price,
                'unit' => ['kg', 'g', 'lb', 'pcs'][array_rand(['kg', 'g', 'lb', 'pcs'])],
                'total' => $quantity * $price
            ]);
        }
    }
}
