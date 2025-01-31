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
        // Create 10 back order items using the BoItemFactory
        BoItem::factory()->count(10)->create();
    }
}
