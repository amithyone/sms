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
            $table->timestamp('refunded_at')->nullable()->after('delivered_at');
            $table->decimal('refund_amount', 10, 2)->nullable()->after('refunded_at');
            $table->unsignedBigInteger('refund_transaction_id')->nullable()->after('refund_amount');
            $table->string('refund_reason')->nullable()->after('refund_transaction_id');
            
            $table->foreign('refund_transaction_id')->references('id')->on('wallet_transactions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['refund_transaction_id']);
            $table->dropColumn(['refunded_at', 'refund_amount', 'refund_transaction_id', 'refund_reason']);
        });
    }
};
