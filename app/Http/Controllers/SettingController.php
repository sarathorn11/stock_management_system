<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function __construct()
    {
        // Share the setting data across all views
        $setting = Setting::first();
    
        if (!$setting) {
            $setting = new Setting([
                'system_name' => 'Stock Management System',
                'system_short_name' => 'SMS',
                // Add other necessary defaults if needed
            ]);
            $setting->save();  // Save the new setting instance to the database
        }
        view()->share('setting', $setting);
    }
    

    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('setting.index', compact('setting'));
    }

    public function edit()
    {
        $setting = Setting::first();

        if (!$setting) {
            return redirect()->route('setting.index')->with('error', 'Setting not found.');
        }

        return view('setting.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        // Validate the request data
        $validatedData = $request->validate([
            'system_name' => 'required|string|max:255',
            'system_short_name' => 'required|string|max:255',
            'system_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'system_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle logo file upload
        if ($request->hasFile('system_logo')) {
            // Delete old logo if exists
            if ($setting->system_logo && Storage::disk('public')->exists($setting->system_logo)) {
                Storage::disk('public')->delete($setting->system_logo);
            }
            $validatedData['system_logo'] = $request->file('system_logo')->store('logos', 'public');
        }

        // Handle cover file upload
        if ($request->hasFile('system_cover')) {
            // Delete old cover if exists
            if ($setting->system_cover && Storage::disk('public')->exists($setting->system_cover)) {
                Storage::disk('public')->delete($setting->system_cover);
            }
            $validatedData['system_cover'] = $request->file('system_cover')->store('covers', 'public');
        }

        // Update the settings with the new data
        $setting->update($validatedData);

        return redirect()->route('setting.index')->with('success', 'Setting updated successfully.');
    }
}
