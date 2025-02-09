<?php

namespace Database\Seeders;

use App\Models\BackOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BackOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 back orders using the BackOrderFactory
        // BackOrder::factory()->count(10)->create();

        // Create 10 back orders manually
        for ($i = 1; $i <= 10; $i++) {
            BackOrder::create([
                'receiving_id' => rand(1, 10),
                'po_id' => rand(1, 10),
                'supplier_id' => rand(1, 5),
                'bo_code' => 'BO' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'amount' => rand(100, 1000),
                'discount_perc' => rand(0, 10),
                'discount' => rand(0, 100),
                'tax_perc' => rand(0, 10),
                'tax' => rand(0, 100),
                'remarks' => 'Remarks for back order ' . $i,
                'status' => rand(0, 2)
            ]);
        }
    }
}
