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
        // Create roles
        Role::create(['name' => 'basic']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'super_admin']);
        Role::create(['name' => 'teacher']);

        // Optionally assign super_admin to the first user
        $firstUser = User::first();
        if ($firstUser) {
            $firstUser->assignRole('super_admin');
            $this->command->info("Super admin role assigned to user: {$firstUser->email}");
        }
    }
}
