<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('authenticate.register');
    }

    public function register(Request $request)
{
    // Validate input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:15|unique:users,phone',
        'password' => 'required|string|min:6|confirmed',
        'tenant_name' => 'required|string|max:255|unique:tenants,name',
    ]);

    if ($validator->fails()) {
        return redirect()->route('register')
                         ->withErrors($validator)
                         ->withInput();
    }

    // Create tenant database name
    $sanitizedTenantName = Str::slug($request->tenant_name, '_'); 
    $databaseName = 'tenant_' . $sanitizedTenantName;

    // Create the Tenant
    $tenant = Tenant::create([
        'name' => $request->tenant_name,
        'domain' => Str::slug($request->tenant_name) . '.example.com',
        'database_name' => $databaseName,
        'database_username' => 'user_' . Str::random(5),
        'database_password' => Str::random(10), // Generate a random secure password
    ]);
    

    // Create tenant database
    try {
        DB::statement("CREATE DATABASE {$databaseName}");
    } catch (\Exception $e) {
        return redirect()->route('register')
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

    // Create the first user inside the tenant database
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'status' => 'active',
        'tenant_id' => $tenant->id,
    ]);

    // Log the user in
    Auth::login($user);

    return redirect()->route('dashboard')->with('success', 'Registration successful. Welcome to the dashboard!');
}

}