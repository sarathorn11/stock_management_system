<?php

namespace Database\Seeders;

use App\Models\ReturnList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReturnListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $returnLists = [
            [
                'id' => 1,
                'return_code' => 'R0001',
                'supplier_id' => 1,
                'stock_ids' => json_encode([3]),
                'amount' => 50.00,
                'remarks' => 'Sample remark 1',
            ]
        ];

        // Insert the return lists into the database
        foreach ($returnLists as $returnList) {
            ReturnList::create($returnList);
        }
    }
}
