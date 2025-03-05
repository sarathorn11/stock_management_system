<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 stocks using the StockFactory
        // Stock::factory()->count(10)->create();

        // Create 20 stocks manually
        for ($i = 1; $i <= 20; $i++) {
            $quantity = rand(1, 100);
            $price = rand(10, 1000);
            Stock::create([
                'item_id' => rand(1, 20),
                'quantity' => $quantity,
                'price' => $price,
                // 'unit' => ['kg', 'g', 'lb', 'pcs'][array_rand(['kg', 'g', 'lb', 'pcs'])],
                'total' => $quantity * $price,
                'type' => rand(1, 2),
            ]);
        }
    }
}
