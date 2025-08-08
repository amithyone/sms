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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Base amount user wants to fund
            $table->decimal('charge', 10, 2); // Processing charge
            $table->decimal('final_amount', 10, 2); // Amount + charge
            $table->string('ref_id')->unique(); // Unique reference ID
            $table->integer('method'); // Payment method (118 for XtraPay, 119 for PayVibe)
            $table->integer('type')->default(2); // Transaction type
            $table->integer('status')->default(1); // 1=pending, 2=completed, 3=failed
            $table->json('detail')->nullable(); // Virtual account details and other metadata
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['ref_id']);
            $table->index(['method', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
