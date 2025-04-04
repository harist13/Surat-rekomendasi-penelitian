<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        // Ensure the roles are created with the correct guard
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);

         // Create admin user
        $admin = User::create([
            'nip' => '001',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'no_telp' => '08123456789',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create staff user
        $staff = User::create([
            'nip' => '002',
            'username' => 'staff',
            'password' => Hash::make('password'),
            'no_telp' => '08987654321',
            'email' => 'staff@example.com',
            'role' => 'staff',
        ]);

        // Berikan role superadmin kepada pengguna tersebut
        $admin->assignRole('admin');
        $staff->assignRole('staff');
    }
}