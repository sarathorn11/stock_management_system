<?php

namespace Database\Seeders;

use App\Models\PoItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 purchase order items using the PoItemFactory
        PoItem::factory()->count(10)->create();
    }
}
