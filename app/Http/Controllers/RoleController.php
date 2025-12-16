<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of users with their roles.
     */
    public function index()
    {
        // If request is coming from DataTables AJAX, use getData instead
        if (request()->ajax()) {
            return $this->getData();
        }
        
        return view('roles.index');
    }

    /**
     * Get data for DataTables AJAX
     */
    public function getData()
    {
        $query = User::with('roles')->orderBy('name');

        // Apply role filter
        if (request()->has('role') && request('role') != '') {
            $query->whereHas('roles', function($q) {
                $q->where('name', request('role'));
            });
        }

        // Apply search
        if (request()->has('search') && request('search.value') != '') {
            $search = request('search.value');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get total records before pagination
        $totalData = $query->count();

        // Apply ordering
        $columns = ['id', 'name', 'email', 'role'];
        if (request()->has('order')) {
            $orderColumnIndex = request('order.0.column');
            $orderDir = request('order.0.dir');
            if (isset($columns[$orderColumnIndex]) && in_array($columns[$orderColumnIndex], ['id', 'name', 'email'])) {
                $query->orderBy($columns[$orderColumnIndex], $orderDir);
            }
        }

        // Apply pagination
        $start = request('start', 0);
        $length = request('length', 10);
        $users = $query->skip($start)->take($length)->get();

        // Format data for DataTables
        $data = [];
        foreach ($users as $index => $user) {
            $roleName = $user->roles->first()?->name ?? 'No Role';
            $badgeClass = match($roleName) {
                'admin' => 'danger',
                'teacher' => 'warning',
                'student' => 'info',
                default => 'secondary'
            };

            $data[] = [
                'number' => $start + $index + 1,
                'name' => $user->name,
                'email' => $user->email,
                'role' => '<span class="badge bg-' . $badgeClass . '">' . ucfirst(str_replace('_', ' ', $roleName)) . '</span>',
                'actions' => '
                    <div class="action d-flex gap-2 justify-content-center">
                        <a href="#" class="text-warning edit-role" data-id="' . $user->id . '" title="Edit Role">
                            <i class="lni lni-pencil"></i>
                        </a>
                    </div>'
            ];
        }

        return response()->json([
            'draw' => intval(request('draw')),
            'recordsTotal' => User::count(),
            'recordsFiltered' => $totalData,
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the user's role.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        
        // If AJAX request, return partial view for modal
        if (request()->ajax()) {
            return view('roles.partials.edit', compact('user', 'roles'));
        }
        
        return view('roles.edit', compact('user', 'roles'));
    }

    /**
     * Update the user's role.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        // Sync roles (remove all existing roles and assign the new one)
        $user->syncRoles([$request->role]);

        // Sync custom permissions
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        } else {
            // If no custom permissions selected, remove all direct permissions
            // User will inherit permissions from their role
            $user->syncPermissions([]);
        }

        // Handle AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Role and permissions updated successfully.'
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Role dan permission berhasil diperbarui.');
    }
}
