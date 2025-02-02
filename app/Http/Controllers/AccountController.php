<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // Show the account page
    public function index()
    {
        return view('auth.account');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update the user information
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;

        // If password is filled, update it
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Handle file upload for profile picture
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture (if any)
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $user->profile_picture = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Save updated user information
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Account updated successfully!');
    }
}