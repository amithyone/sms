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
        Schema::create('variation_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variation_id')->constrained()->onDelete('cascade');
            $table->string('value'); // e.g., "S", "M", "L", "XL" for size
            $table->string('label')->nullable(); // e.g., "Small", "Medium", "Large", "Extra Large"
            $table->decimal('price_adjustment', 10, 2)->default(0); // Price difference for this option
            $table->integer('stock')->default(0); // Stock for this specific variation
            $table->string('sku')->nullable(); // SKU for this specific variation
            $table->string('image')->nullable(); // Image for this specific variation (e.g., color swatch)
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_options');
    }
};
