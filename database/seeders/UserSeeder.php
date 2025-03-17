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
        $users = [
            [
                'username' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'gender' => 'male',
                'profile_picture' => 'https://i.pinimg.com',
                'email_verified_at' => now(),
                'remember_token' => 'token',
            ],
            [
                'username' => 'user',
                'first_name' => 'User',
                'last_name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'gender' => 'female',
                'profile_picture' => 'https://i.pinimg.com',
                'email_verified_at' => now(),
                'remember_token' => 'token',
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
