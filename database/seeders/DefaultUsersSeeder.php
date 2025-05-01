<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    public function run()
    {
        // Create Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Create Manager Role
        $managerRole = Role::firstOrCreate(['name' => 'Manager']);

        // Create Admin User
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'phone' => '1234567890',
            'password' => Hash::make('12345611'), // Default password
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        // Create Manager User
        User::firstOrCreate([
            'email' => 'manager@example.com',
        ], [
            'name' => 'Manager User',
            'phone' => '0987654321',
            'password' => Hash::make('12345611'), // Default password
            'role_id' => $managerRole->id,
            'status' => 'active',
        ]);
    }
}
