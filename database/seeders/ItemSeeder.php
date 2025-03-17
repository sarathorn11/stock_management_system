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
        $items = [
            [
                'id' => 1,
                'name' => 'Book',
                'description' => 'Description for item 1',
                'supplier_id' => 1,
                'cost' => 50,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 2,
                'name' => 'Pen',
                'description' => 'Description for item 2',
                'supplier_id' => 2,
                'cost' => 10,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 3,
                'name' => 'Pencil',
                'description' => 'Description for item 3',
                'supplier_id' => 3,
                'cost' => 5,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 4,
                'name' => 'Eraser',
                'description' => 'Description for item 4',
                'supplier_id' => 4,
                'cost' => 2,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 5,
                'name' => 'Ruler',
                'description' => 'Description for item 5',
                'supplier_id' => 5,
                'cost' => 3,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 6,
                'name' => 'Notebook',
                'description' => 'Description for item 6',
                'supplier_id' => 1,
                'cost' => 20,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 7,
                'name' => 'Stapler',
                'description' => 'Description for item 7',
                'supplier_id' => 2,
                'cost' => 30,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 8,
                'name' => 'Staple Wire',
                'description' => 'Description for item 8',
                'supplier_id' => 3,
                'cost' => 5,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 9,
                'name' => 'Scissors',
                'description' => 'Description for item 9',
                'supplier_id' => 4,
                'cost' => 15,
                'unit' => 'pcs',
                'status' => 1
            ],
            [
                'id' => 10,
                'name' => 'Glue',
                'description' => 'Description for item 10',
                'supplier_id' => 5,
                'cost' => 10,
                'unit' => 'pcs',
                'status' => 1
            ]
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
