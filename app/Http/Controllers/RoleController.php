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
        $users = User::with('roles')->orderBy('name')->paginate(10);
        return view('roles.index', compact('users'));
    }

    /**
     * Show the form for editing the user's role.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('roles.edit', compact('user', 'roles'));
    }

    /**
     * Update the user's role.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Sync roles (remove all existing roles and assign the new one)
        $user->syncRoles([$request->role]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }
}
