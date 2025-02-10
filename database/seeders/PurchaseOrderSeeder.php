<?php

namespace Database\Seeders;

use App\Models\PurchaseOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 purchase orders using the PurchaseOrderFactory
        // PurchaseOrder::factory()->count(10)->create();

        // Create 10 purchase orders manually
        for ($i = 1; $i <= 10; $i++) {
            PurchaseOrder::create([
                'supplier_id' => rand(1, 5),
                'po_code' => 'PO' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'amount' => rand(100, 1000),
                'discount_perc' => rand(0, 10),
                'discount' => rand(0, 100),
                'tax_perc' => rand(0, 10),
                'tax' => rand(0, 100),
                'remarks' => 'Remarks for purchase order ' . $i,
                'status' => rand(0, 2)
            ]);
        }
    }
}
