<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('backend.roles.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'status' => 'required|in:active,inactive',
        ]);

        Role::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'status' => 'required|in:active,inactive',
        ]);

        $role->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully!');
    }
}
