<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Models\Tenant;

class IdentifyTenant
{
    public function handle($request, Closure $next)
    {
        // Get the logged-in user
        $user = auth()->user();

        if ($user && $user->tenant) {
            // Get the tenant's database name
            $databaseName = $user->tenant->database_name;

            // Set the tenant's database connection
            Config::set('database.connections.tenant.database', $databaseName);

            // Switch to the tenant's database
            DB::purge('tenant');
            DB::reconnect('tenant');
            Config::set('database.default', 'tenant');
        }

        return $next($request);
    }
}