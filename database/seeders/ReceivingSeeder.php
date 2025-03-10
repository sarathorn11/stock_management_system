<?php

namespace Database\Seeders;

use App\Models\Receiving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceivingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 receivings using the ReceivingFactory
        // Receiving::factory()->count(10)->create();

        $stockIds = [
            [5, 3], [4, 9], [4, 7], [8, 2], [6, 1],
            [3, 5], [7, 4], [2, 8], [1, 6], [9, 4]
        ]; // Predefined array of stock_ids

        // Create 10 receivings manually
        for ($i = 1; $i <= 10; $i++) {
            Receiving::create([
                'from_id' => rand(1, 20),
                'from_order' => rand(1, 2),
                'from_type' => rand(1,2),
                'amount' => rand(100, 1000),
                'discount_perc' => rand(0, 10),
                'discount' => rand(0, 100),
                'tax_perc' => rand(0, 10),
                'tax' => rand(0, 100),
                'remarks' => 'Remarks for receiving ' . $i,
                'stock_ids' => json_encode($stockIds[$i - 1]) // Store multiple stock_ids as JSON
            ]);
        }
    }
}

