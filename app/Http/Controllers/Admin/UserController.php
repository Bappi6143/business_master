<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Fetch users for the current tenant (if tenant_id is set in the session or auth)
        $users = User::with(['role', 'tenant'])->get();
        $roles = Role::all(); 
        $tenants = Tenant::all(); 

        return view('backend.users.index', compact('users', 'roles', 'tenants'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
            'tenant_name' => 'required|string|max:255|unique:tenants,name', // Validate tenant name
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.index')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Create the tenant
        $sanitizedTenantName = Str::slug($request->tenant_name, '_');
        $databaseName = 'tenant_' . $sanitizedTenantName;

        $tenant = Tenant::create([
            'name' => $request->tenant_name,
            'domain' => Str::slug($request->tenant_name) . '.example.com',
            'database_name' => $databaseName,
            'database_username' => 'user_' . Str::random(5),
            'database_password' => Str::random(10), // Generate a random secure password
        ]);

        // Create the tenant database
        try {
            DB::statement("CREATE DATABASE {$databaseName}");
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                             ->withErrors(['tenant_name' => 'Failed to create database.'])
                             ->withInput();
        }

        // Set tenant database connection
        $tenant->configureDatabase();

        // Run migrations for the new tenant
        \Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations/tenant', 
            '--force' => true,
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'role_id' => $request->role_id,
            'tenant_id' => $tenant->id, // Assign the tenant ID
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = Role::all(); // Fetch all roles for the role dropdown
        return view('backend.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $user->id)
                            ->withErrors($validator)
                            ->withInput();
        }

        // Update the user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'role_id' => $request->role_id,
        ]);

        // Update password if provided
        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        // If the user is deactivated, log them out
        if ($request->status === 'inactive') {
            // Invalidate the user's session
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}