<?php

namespace App\Providers;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ViewServiceProvider extends ServiceProvider
{
   
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */

     public function boot()
    {
        // Check if the 'setting' table exists before running any queries
        if (Schema::hasTable('setting')) {
            // Fetch setting only if the table exists
            $setting = Setting::firstOrCreate([
                'system_name' => 'Stock Management System',
                'system_short_name' => 'SMS',
            ]);

            View::share('setting', $setting);
        }
    }
}
