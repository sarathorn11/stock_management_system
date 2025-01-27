<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        supplier::factory()->count(50)->create();
    }
}
