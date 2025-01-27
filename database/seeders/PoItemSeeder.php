<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PoItem;

class PoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PoItem::factory()->count(50)->create();
    }
}
