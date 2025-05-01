<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_contact');
            $table->string('customer_name');
            $table->text('customer_address');
            $table->json('products'); // Store products as JSON
            $table->integer('ordered_quantity'); // Total ordered quantity for the order
            $table->string('order_status');
            $table->decimal('total_price', 10, 2);
            $table->foreignId('delivery_zone_id')->nullable()->constrained('delivery_charges');
            $table->string('zone_name'); // Add this to store the zone name
            $table->decimal('delivery_charge', 10, 2); // Add this to store the charge
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
