<?php

namespace Database\Seeders;

use App\Models\PoItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $poItems = [
            [
                'po_id' => 1,
                'item_id' => 1,
                'quantity' => 10,
                'price' => 50.00,
                // 'unit' => 'kg',
                'total' => 500.00
            ],
            [
                'po_id' => 2,
                'item_id' => 2,
                'quantity' => 20,
                'price' => 10.00,
                // 'unit' => 'g',
                'total' => 200.00
            ],
            [
                'po_id' => 3,
                'item_id' => 3,
                'quantity' => 15,
                'price' => 5.00,
                // 'unit' => 'lb',
                'total' => 75.00
            ]
        ];

        foreach ($poItems as $item) {
            PoItem::create($item);
        }
    }
}
