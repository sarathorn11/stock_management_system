<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 items using the ItemFactory
        // Item::factory()->count(10)->create();

        // Create 20 items manually
        for ($i = 1; $i <= 20; $i++) {
            Item::create([
                'name' => 'Item ' . $i,
                'description' => 'Description for item ' . $i,
                'supplier_id' => rand(1, 5),
                'cost' => rand(10, 100),
                'unit' => ['kg', 'g', 'lb', 'pcs'][array_rand(['kg', 'g', 'lb', 'pcs'])],
                'status' => 1
            ]);
        }
    }
}
