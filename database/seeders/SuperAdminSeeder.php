<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'Super@gmail',
                'password' => 'password123',
                'role' => 'Super Admin'
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 'password123',
                'role' => 'Admin'
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => 'password123',
                'role' => 'Manager'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password'])
            ]);
            $user->assignRole($userData['role']);
        }
    }
}
