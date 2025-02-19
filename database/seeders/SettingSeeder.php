<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('setting')->insert([
            'system_name' => 'Stock Management System',
            'system_short_name' => 'SMS',
            'system_logo' => null, // Keep null if there's no default logo
            'system_cover' => null, // Keep null if there's no default cover
        ]);
    }
}
