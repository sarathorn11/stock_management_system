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
        $setting = Setting::first();

        if (!$setting) {
            $setting = (object) [
                'system_name' => 'Stock Management System',
            ];
        }

        // Share setting data across all views
        View::share('setting', $setting);
    }
}
