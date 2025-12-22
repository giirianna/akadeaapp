<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CustomRoleController extends Controller
{
    /**
     * Display a listing of all roles.
     */
    public function index()
    {
        $roles = Role::withCount('users', 'permissions')->get();
        
        return view('roles.custom.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        // Get all permissions grouped by module
        $permissions = $this->getGroupedPermissions();
        
        return view('roles.custom.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name|regex:/^[a-z_]+$/',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.regex' => 'Role name must be lowercase letters and underscores only (e.g., custom_role)',
            'name.unique' => 'This role name already exists.',
        ]);

        // Create the role
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        // Assign permissions to the role
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()
            ->route('roles.custom.index')
            ->with('success', 'Custom role created successfully!');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        // Get all permissions grouped by module
        $permissions = $this->getGroupedPermissions();
        
        // Get current role permissions
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        return view('roles.custom.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        // Prevent editing base roles
        if (in_array($role->name, ['admin', 'teacher', 'student'])) {
            return redirect()
                ->route('roles.custom.index')
                ->with('error', 'Cannot edit base roles (admin, teacher, student).');
        }

        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-z_]+$/|unique:roles,name,' . $role->id,
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ], [
            'name.regex' => 'Role name must be lowercase letters and underscores only (e.g., custom_role)',
        ]);

        // Update role name
        $role->update([
            'name' => $request->name,
        ]);

        // Sync permissions
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()
            ->route('roles.custom.index')
            ->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        // Prevent deletion of base roles
        if (in_array($role->name, ['admin', 'teacher', 'student'])) {
            return redirect()
                ->route('roles.custom.index')
                ->with('error', 'Cannot delete base roles (admin, teacher, student).');
        }

        // Check if role is assigned to any users
        if ($role->users()->count() > 0) {
            return redirect()
                ->route('roles.custom.index')
                ->with('error', 'Cannot delete role that is assigned to users. Please reassign users first.');
        }

        $role->delete();

        return redirect()
            ->route('roles.custom.index')
            ->with('success', 'Role deleted successfully!');
    }

    /**
     * Get permissions grouped by module.
     */
    private function getGroupedPermissions()
    {
        $allPermissions = Permission::all();
        $grouped = [];

        foreach ($allPermissions as $permission) {
            // Extract module name from permission (e.g., "students.view" -> "students")
            $parts = explode('.', $permission->name);
            $module = $parts[0];
            $action = $parts[1] ?? '';

            if (!isset($grouped[$module])) {
                $grouped[$module] = [
                    'name' => ucfirst($module),
                    'permissions' => [],
                ];
            }

            $grouped[$module]['permissions'][] = [
                'name' => $permission->name,
                'action' => $action,
                'label' => $this->getPermissionLabel($action),
            ];
        }

        return $grouped;
    }

    /**
     * Get human-readable label for permission action.
     */
    private function getPermissionLabel($action)
    {
        $labels = [
            'view' => 'View',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'view_submissions' => 'View Submissions',
            'manage' => 'Manage',
            'assign' => 'Assign to Users',
        ];

        return $labels[$action] ?? ucfirst(str_replace('_', ' ', $action));
    }
}
