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
        $backOrders = [
            [
                'id' => 1,
                'receiving_id' => 2,
                'po_id' => 3,
                'supplier_id' => 3,
                // 'bo_code' => 'BO0001',
                'amount' => 25.00,
                'discount_perc' => 0.00,
                'discount' => 0.00,
                'tax_perc' => 0.00,
                'tax' => 0.00,
                'remarks' => 'Remarks for back order 1',
                'status' => 0
            ],
        ];

        foreach ($backOrders as $order) {
            BackOrder::create($order);
        }
    }
}
