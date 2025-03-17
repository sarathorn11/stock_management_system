<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Supplier 1',
                'address' => 'Address Supplier 1',
                'cperson' => 'Jonh Smit',
                'contact' => '0978767677'
            ],
            [
                'name' => 'Supplier 2',
                'address' => 'Address Supplier 2',
                'cperson' => 'Jonh Doe',
                'contact' => '0978767678'
            ],
            [
                'name' => 'Supplier 3',
                'address' => 'Address Supplier 3',
                'cperson' => 'Jonh Wick',
                'contact' => '0978767679'
            ],
            [
                'name' => 'Supplier 4',
                'address' => 'Address Supplier 4',
                'cperson' => 'Jonh Cena',
                'contact' => '0978767676'
            ],
            [
                'name' => 'Supplier 5',
                'address' => 'Address Supplier 5',
                'cperson' => 'Jonh Snow',
                'contact' => '0978767675'
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
