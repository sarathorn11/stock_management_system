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
        $receivings = [
            [
                'id' => 1,
                'from_id' => 1,
                'from_type' => 'App\Models\PurchaseOrder',
                'from_order' => 1,
                'amount' => 500.00,
                'discount_perc' => 0.00,
                'discount' => 0.00,
                'tax_perc' => 0.00,
                'tax' => 0.00,
                'remarks' => 'Remarks for receiving 1',
                'stock_ids' => json_encode([1])
            ],
            [
                'id' => 2,
                'from_id' => 3,
                'from_type' => 'App\Models\PurchaseOrder',
                'from_order' => 1,
                'amount' => 0.00,
                'discount_perc' => 0.00,
                'discount' => 0.00,
                'tax_perc' => 0.00,
                'tax' => 0.00,
                'remarks' => 'Remarks for receiving 2',
                'stock_ids' => json_encode([2])
            ]
        ];

        foreach ($receivings as $receiving) {
            Receiving::create($receiving);
        }
    }
}
