<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 sales using the SaleFactory
        // Sale::factory()->count(10)->create();

        $stockIds = [
            [5, 3], [4, 9], [4, 7], [8, 2], [6, 1],
            [3, 5], [7, 4], [2, 8], [1, 6], [9, 4]
        ]; // Predefined array of stock_ids
        // Create 10 sales manually
        for ($i = 1; $i <= 10; $i++) {
            Sale::create([
                'sales_code' => 'SALE' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'client' => 'Client ' . $i,
                // 'stock_ids' => json_encode($stockIds[$i - 1]), // Store multiple stock_ids as JSON
                'amount' => rand(100, 1000),
                'remarks' => 'Remarks for sale ' . $i,
            ]);
        }
    }
}
