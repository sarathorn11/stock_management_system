<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 users using the UserFactory
        // User::factory()->count(10)->create();

        // Create 5 users manually
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'username' => 'User ' . $i,
                'first_name' => 'First Name ' . $i,
                'last_name' => 'Last Name ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password' . $i),
                'role' => ['admin', 'user'][array_rand(['admin', 'user'])],
                'gender' => ['male', 'female'][array_rand(['male', 'female'])],
                'profile_picture' => 'https://i.pinimg.com/736x/c1/e8/e9/c1e8e994e711bc3145cac7e39f63fa8f.jpg',
                'email_verified_at' => now(),
                'remember_token' => 'token' . $i,
            ]);
        }
    }
}
