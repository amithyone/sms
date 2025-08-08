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
            $table->text('shipping_notes')->nullable()->after('delivery_note');
            $table->timestamp('delivered_at')->nullable()->after('delivery_date');
            $table->string('tracking_url')->nullable()->after('tracking_number');
            $table->string('carrier')->nullable()->after('tracking_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_notes', 'delivered_at', 'tracking_url', 'carrier']);
        });
    }
};
