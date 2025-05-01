<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Required
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Required
            $table->string('code')->unique(); // Required
            $table->integer('initial_quantity'); // Required
            $table->integer('stock_quantity')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->onDelete('set null');
            $table->json('variant_items')->nullable(); // Multi-variant data stored as JSON array
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
