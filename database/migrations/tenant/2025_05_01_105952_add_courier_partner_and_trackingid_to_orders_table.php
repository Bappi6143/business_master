<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('courier_partner')->nullable();
            $table->string('trackingid')->nullable();
            $table->json("courier_response")->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['courier_partner', 'trackingid', 'courier_response']);
        });
    }
};
