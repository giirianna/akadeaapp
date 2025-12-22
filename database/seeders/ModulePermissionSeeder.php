<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModulePermissionSeeder extends Seeder
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
            'students' => [
                'view' => 'View students list and details',
                'create' => 'Create new students',
                'edit' => 'Edit student information',
                'delete' => 'Delete students',
            ],
            'teachers' => [
                'view' => 'View teachers list and details',
                'create' => 'Create new teachers',
                'edit' => 'Edit teacher information',
                'delete' => 'Delete teachers',
            ],
            'subjects' => [
                'view' => 'View subjects list and details',
                'create' => 'Create new subjects',
                'edit' => 'Edit subject information',
                'delete' => 'Delete subjects',
            ],
            'spp' => [
                'view' => 'View SPP payments',
                'create' => 'Create SPP payment records',
                'edit' => 'Edit SPP payment information',
                'delete' => 'Delete SPP payment records',
            ],
            'exams' => [
                'view' => 'View exams list',
                'create' => 'Create new exams',
                'edit' => 'Edit exam information',
                'delete' => 'Delete exams',
                'view_submissions' => 'View exam submissions and results',
            ],
            'roles' => [
                'view' => 'View roles and permissions',
                'manage' => 'Create, edit, and delete custom roles',
                'assign' => 'Assign roles to users',
            ],
        ];

        // Create permissions
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action => $description) {
                Permission::firstOrCreate(
                    ['name' => "{$module}.{$action}"],
                    ['guard_name' => 'web']
                );
            }
        }

        // Assign all permissions to admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        // Assign teacher-specific permissions
        $teacherRole = Role::firstOrCreate(['name' => 'teacher', 'guard_name' => 'web']);
        $teacherRole->givePermissionTo([
            // Can view students
            'students.view',
            
            // Full access to subjects
            'subjects.view',
            'subjects.create',
            'subjects.edit',
            
            // Full access to exams
            'exams.view',
            'exams.create',
            'exams.edit',
            'exams.delete',
            'exams.view_submissions',
            
            // Can view teachers
            'teachers.view',
        ]);

        // Assign student-specific permissions
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        $studentRole->givePermissionTo([
            // Can only view their own exams (handled in controller)
            'exams.view',
        ]);

        $this->command->info('✅ Module permissions created successfully!');
        $this->command->info('✅ Permissions assigned to base roles (admin, teacher, student)');
    }
}
