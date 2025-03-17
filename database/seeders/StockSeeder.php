<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            [
                'id' => 1,
                'item_id' => 1,
                'quantity' => 10,
                'price' => 50.00,
                'total' => 500.00,
                'type' => 1,
            ],
            [
                'id' => 2,
                'item_id' => 3,
                'quantity' => 10,
                'price' => 5.00,
                'total' => 50.00,
                'type' => 1,
            ],
            [
                'id' => 3,
                'item_id' => 1,
                'quantity' => 5,
                'price' => 50.00,
                'total' => 250.00,
                'type' => 2,
            ],
            // [
            //     'item_id' => 4,
            //     'quantity' => 25,
            //     'price' => 20.00,
            //     'total' => 500.00,
            //     'type' => 1,
            // ],
            // [
            //     'item_id' => 5,
            //     'quantity' => 30,
            //     'price' => 25.00,
            //     'total' => 750.00,
            //     'type' => 1,
            // ],
            // [
            //     'item_id' => 6,
            //     'quantity' => 35,
            //     'price' => 15.00,
            //     'total' => 525.00,
            //     'type' => 1,
            // ],
            // [
            //     'item_id' => 7,
            //     'quantity' => 40,
            //     'price' => 10.00,
            //     'total' => 400.00,
            //     'type' => 1,
            // ],
            // [
            //     'item_id' => 8,
            //     'quantity' => 45,
            //     'price' => 5.00,
            //     'total' => 225.00,
            //     'type' => 1,
            // ],
            // [
            //     'item_id' => 9,
            //     'quantity' => 50,
            //     'price' => 2.50,
            //     'total' => 125.00,
            //     'type' => 1,
            // ],
            // [
            //     'item_id' => 10,
            //     'quantity' => 55,
            //     'price' => 1.00,
            //     'total' => 55.00,
            //     'type' => 1,
            // ]
        ];

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }
    }
}
