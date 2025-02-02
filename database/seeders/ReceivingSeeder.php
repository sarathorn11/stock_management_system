<?php

namespace Database\Seeders;

use App\Models\Receiving;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceivingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 receivings using the ReceivingFactory
        Receiving::factory()->count(10)->create();
    }
}
