<?php

namespace Database\Seeders;

use App\Models\BackOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BackOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 back orders using the BackOrderFactory
        BackOrder::factory()->count(10)->create();
    }
}
