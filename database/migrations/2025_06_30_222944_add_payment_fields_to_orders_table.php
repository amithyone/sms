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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_amount', 10, 2)->after('total')->nullable();
            $table->decimal('delivery_fee', 10, 2)->default(500)->after('total_amount');
            $table->string('payment_reference')->nullable()->after('payment_method');
            $table->string('status')->default('pending')->after('payment_reference');
            $table->timestamp('paid_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'total_amount',
                'delivery_fee',
                'payment_reference',
                'status',
                'paid_at'
            ]);
        });
    }
};
