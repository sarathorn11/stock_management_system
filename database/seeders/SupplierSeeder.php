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
        // Create 10 suppliers using the SupplierFactory
        // Supplier::factory()->count(10)->create();

        // Create 5 suppliers manually
        for ($i = 1; $i <= 5; $i++) {
            Supplier::create([
                'name' => 'Supplier ' . $i,
                'address' => 'Address ' . $i,
                'cperson' => 'Contact Person ' . $i,
                'contact' => '097876767 ' . $i
            ]);
        }
    }
}
