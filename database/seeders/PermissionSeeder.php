<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define modules and their permissions
        $modules = [
            'dashboard',
            'students',
            'teachers',
            'spp',
            'subjects',
            'exams_students',
            'exams_teachers',
            'roles',
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        // Create permissions for each module
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web'
                ]);
            }
        }

        // Assign default permissions to roles
        $admin = Role::findByName('admin');
        $teacher = Role::findByName('teacher');
        $student = Role::findByName('student');

        // Admin gets all permissions
        $admin->givePermissionTo(Permission::all());

        // Teacher gets permissions for Home + Management modules
        $teacherPermissions = [
            // Dashboard (view only)
            'dashboard.view',
            
            // Students (full access)
            'students.view', 'students.create', 'students.edit', 'students.delete',
            
            // SPP (full access)
            'spp.view', 'spp.create', 'spp.edit', 'spp.delete',
            
            // Exams Students (view only)
            'exams_students.view',
            
            // Exams Teachers (full access)
            'exams_teachers.view', 'exams_teachers.create', 'exams_teachers.edit', 'exams_teachers.delete',
        ];
        $teacher->givePermissionTo($teacherPermissions);

        // Student gets permissions for Home menu only
        $studentPermissions = [
            'dashboard.view',
            'exams_students.view',
        ];
        $student->givePermissionTo($studentPermissions);
    }
}
