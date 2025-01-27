<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Receiving;

class ReceivingSeeder extends Seeder
{
    public function run()
    {
        Receiving::factory()->count(50)->create();
    }
}
