<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Setting::create([
            'system_name' => 'Stock Management System',
            'system_short_name' => 'SMS',
            'system_logo' => 'uploads/logo.png', // Path to the logo
            'system_cover' => 'uploads/cover.png', // Path to the cover image
        ]);
    }
}
