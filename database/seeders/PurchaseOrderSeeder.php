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
        $purchaseOrders = [
            [
                'id' => 1,
                'supplier_id' => 1,
                'po_code' => 'PO0001',
                'amount' => 500.00,
                'discount_perc' => 0.00,
                'discount' => 0.00,
                'tax_perc' => 0.00,
                'tax' => 0.00,
                'remarks' => 'Remarks for purchase order 1',
                'status' => 2
            ],
            [
                'id' => 2,
                'supplier_id' => 2,
                'po_code' => 'PO0002',
                'amount' => 200.00,
                'discount_perc' => 0.00,
                'discount' => 0.00,
                'tax_perc' => 0.00,
                'tax' => 0.00,
                'remarks' => 'Remarks for purchase order 2',
                'status' => 0
            ],
            [
                'id' => 3,
                'supplier_id' => 3,
                'po_code' => 'PO0003',
                'amount' => 75.00,
                'discount_perc' => 0.00,
                'discount' => 0.00,
                'tax_perc' => 0.00,
                'tax' => 0.00,
                'remarks' => 'Remarks for purchase order 3',
                'status' => 1
            ]
        ];

        foreach ($purchaseOrders as $order) {
            PurchaseOrder::create($order);
        }
    }
}
