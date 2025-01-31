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
        // Create 10 return lists using the ReturnListFactory
        ReturnList::factory()->count(10)->create();
    }
}
