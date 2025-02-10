<?php

namespace Database\Seeders;

use App\Models\ReturnList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReturnListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 return lists using the ReturnListFactory
        // ReturnList::factory()->count(10)->create();

        // Create 10 return lists based on the table structure
        $stockIds = [
            [5, 3], [4, 9], [4, 7], [8, 2], [6, 1],
            [3, 5], [7, 4], [2, 8], [1, 6], [9, 4]
        ]; // Predefined array of stock_ids
        for ($i = 0; $i < 10; $i++) {
            ReturnList::create([
                'return_code' => 'R' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'supplier_id' => rand(1, 5),
                'stock_ids' => json_encode($stockIds[$i]), // Store multiple stock_ids as JSON
                'amount' => rand(100, 1000) / 10,
                'remarks' => 'Sample remark ' . ($i + 1),
            ]);
        }
    }
}
