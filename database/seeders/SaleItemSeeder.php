<?php

namespace Database\Seeders;

use App\Models\SaleItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saleItems = [
            [
                'id' => 1,
                'sale_id' => 1,
                'item_id' => 1,
                'quantity' => 2,
                'price' => 50.00,
                'total' => 100.00,
            ]
        ];


        foreach ($saleItems as $saleItem) {
            SaleItem::create($saleItem);
        }
    }
}
