<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sales = [
            [
                'id' => 1,
                'sales_code' => 'SALE0001',
                'client' => 'Client 1',
                'amount' => 500.00,
                'remarks' => 'Remarks for sale 1',
            ]
        ];


        foreach ($sales as $sale) {
            Sale::create($sale);
        }
    }
}
