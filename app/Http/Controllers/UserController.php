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
            return $queryBuilder->where('name', 'LIKE', "%{$query}%");
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
                'role' => 'required|string',
                'gender' => 'required|string',
            ]);

            $filename = null;
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/avatars', $filename);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'gender' => $request->gender,
                'avatar' => $filename,
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
                'role' => 'required|string',
                'gender' => 'required|string',
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete the old avatar if it exists
                if ($user->avatar) {
                    Storage::delete('public/avatars/' . $user->avatar);
                }

                $file = $request->file('avatar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/avatars', $filename);
                $user->avatar = $filename;
            }

            // Update user data
            $user->name = $request->name;
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
