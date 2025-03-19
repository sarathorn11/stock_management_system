<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        $perPage = $request->input('perPage', 10);

        $users = User::orderBy('id', 'desc')->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('username', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('first_name', 'LIKE', "%{$query}%")
                ->orWhere('username', 'LIKE', "%{$query}%")
                ->orWhere('gender', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%");
        })
            ->paginate($perPage); // Apply pagination

        return view('users.index', [
            'users' => $users,
            'query' => $query,
            'perPage' => $perPage,
            'perPageOptions' => [10, 20, 30, 50]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            // Validate user data
            $request->validate([

                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|string',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'gender' => 'required|string',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ]);

            $filename = null;
            if ($request->hasFile('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/avatars', $filename);
            }

            User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'profile_picture' => $filename,
            ]);

            return redirect()->route('user.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            // Validate user data
            $request->validate([
                'username' => 'required|string|max:255|unique:users,username,' . $user->id,
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
                'role' => 'required|string',
                'gender' => 'required|string',
            ]);

            // Handle avatar upload
            if ($request->hasFile('profile_picture')) {
                // Delete the old avatar if it exists
                if ($user->profile_picture) {
                    Storage::delete('public/avatars/' . $user->profile_picture);
                }

                $file = $request->file('profile_picture');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/avatars', $filename);
                $user->profile_picture = $filename;
            }

            // Update user data
            $user->username = $request->username;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->role = $request->role;
            $user->gender = $request->gender;
            $user->save();

            return redirect()->route('user.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function deleteSelected(Request $request)
    {
        // Validate that 'ids' is an array
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id', // Ensure each ID exists in the 'items' table
        ]);

        // Delete multiple items
        User::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Selected users deleted successfully.', 'success' => true]);
    }
}