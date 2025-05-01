<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Link to Product
            $table->integer('initial_quantity'); // Initial stock when product is created
            $table->integer('ordered_quantity')->default(0); // Quantity ordered in a particular transaction
            $table->integer('stock_quantity'); // Calculated field (initial_quantity - ordered_quantity)
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Link to Order
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('inventories');
    }
};
