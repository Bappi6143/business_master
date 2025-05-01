<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'domain', 'database_name', 'database_username', 'database_password',
    ];


    public function configureDatabase()
    {
        config([
            'database.connections.tenant.database' => $this->database_name,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }
}