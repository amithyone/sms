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
        Schema::create('product_variation_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('variation_option_id')->constrained()->onDelete('cascade');
            $table->string('variation_name'); // e.g., "Size", "Color"
            $table->string('option_value'); // e.g., "L", "Red"
            $table->string('option_label')->nullable(); // e.g., "Large", "Red"
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variation_options');
    }
};
