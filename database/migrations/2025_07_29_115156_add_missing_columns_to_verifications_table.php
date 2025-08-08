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
        Schema::table('verifications', function (Blueprint $table) {
            // Add missing columns that the code expects
            $table->string('order_id')->nullable()->after('user_id');
            $table->string('sms')->nullable()->after('order_id');
            $table->text('full_sms')->nullable()->after('sms');
            $table->string('country')->nullable()->after('full_sms');
            $table->string('service')->nullable()->after('country');
            $table->decimal('cost', 10, 2)->nullable()->after('service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verifications', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'sms', 'full_sms', 'country', 'service', 'cost']);
        });
    }
};
