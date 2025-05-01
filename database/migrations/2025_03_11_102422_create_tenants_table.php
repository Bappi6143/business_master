<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('tenants', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // Tenant name
        $table->string('domain')->unique(); // Tenant domain (e.g., tenant1.example.com)
        $table->string('database_name')->unique(); // Tenant database name
        $table->string('database_username'); // Database username
        $table->string('database_password'); // Database password
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('tenants');
}
};
