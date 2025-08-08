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
        Schema::create('customizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('type'); // card, print, engrave, embroidery
            $table->text('message')->nullable();
            $table->string('media_path')->nullable(); // For uploaded images
            $table->decimal('additional_cost', 10, 2)->default(0);
            $table->text('special_request')->nullable();
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->boolean('is_active')->default(true);
            
            // Product-specific fields
            $table->string('ring_size')->nullable(); // For jewelry rings
            $table->string('apparel_size')->nullable(); // For hoodies, tshirts, caps
            $table->string('frame_size')->nullable(); // For frames
            $table->string('cup_type')->nullable(); // For cups/mugs
            $table->string('card_type')->nullable(); // For fan cards, ATM cards
            $table->string('pillow_size')->nullable(); // For pillows
            $table->string('blanket_size')->nullable(); // For blankets
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customizations');
    }
};
