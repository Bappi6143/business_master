<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->text('terms_conditions'); // Column for terms and conditions
            $table->text('privacy_policy'); // Column for privacy policy
            $table->text('refund_policy'); // Column for refund policy
            $table->timestamps(); // Automatically adds created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('policies'); // Drop the policies table if the migration is rolled back
    }
};
