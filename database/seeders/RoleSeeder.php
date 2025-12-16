<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete old roles if they exist
        Role::whereIn('name', ['basic', 'super_admin'])->delete();

        // Create 3 base roles
        Role::firstOrCreate(
            ['name' => 'admin'],
            ['guard_name' => 'web']
        );
        
        Role::firstOrCreate(
            ['name' => 'teacher'],
            ['guard_name' => 'web']
        );
        
        Role::firstOrCreate(
            ['name' => 'student'],
            ['guard_name' => 'web']
        );

        // Assign admin role to first user
        $user = \App\Models\User::first();
        if ($user) {
            // Remove old roles
            $user->syncRoles([]);
            // Assign admin role
            $user->assignRole('admin');
        }
    }
}
