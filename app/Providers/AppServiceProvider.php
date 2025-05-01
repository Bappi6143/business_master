<?php

namespace App\Providers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (Auth::check()) {
            $tenant = Tenant::find(Auth::user()->tenant_id);
            if ($tenant) {
                Config::set('database.connections.tenant.database', $tenant->database_name);
                DB::purge('tenant');
                DB::reconnect('tenant');
            }
        }
    }

    public function register(): void
    {
        $this->app->register(\App\Providers\RouteServiceProvider::class); // ✅ এটুকু যোগ করুন
    }

}
