<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BackOrder;

class BackOrderSeeder extends Seeder
{
    public function run()
    {
        BackOrder::factory()->count(50)->create();
    }
}
