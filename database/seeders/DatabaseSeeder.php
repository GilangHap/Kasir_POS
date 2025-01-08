<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Database\Seeders\RolesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin Kasir',
            'email' => 'admin@kasir.com',
            'password' => bcrypt('password'), // Pastikan untuk mengganti password dengan yang aman
        ]);

        // Assign super admin role to admin user
        $adminUser->assignRole('super_admin');
    }
}
