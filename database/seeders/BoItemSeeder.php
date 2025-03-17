<?php

namespace Database\Seeders;

use App\Models\BoItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $boItems = [
            [
                'id' => 1,
                'bo_id' => 1,
                'item_id' => 3,
                'quantity' => 5,
                'price' => 5.00,
                'total' => 25.00
            ]
        ];

        foreach ($boItems as $item) {
            BoItem::create($item);
        }
    }
}
