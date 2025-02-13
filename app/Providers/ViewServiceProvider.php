<?php

namespace App\Providers;
use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $setting = Setting::firstOrCreate([
            'system_name' => 'Stock Management System',
            'system_short_name' => 'SMS',
        ]);
        View::share('setting', $setting);
    }
}
