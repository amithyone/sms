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
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('receiver_house_number')->nullable()->after('receiver_address');
            $table->string('receiver_street')->nullable()->after('receiver_house_number');
            $table->string('receiver_city')->nullable()->after('receiver_street');
            $table->string('receiver_state')->nullable()->after('receiver_city');
            $table->string('receiver_zip')->nullable()->after('receiver_state');
            $table->string('receiver_country')->nullable()->after('receiver_zip');
            $table->enum('receiver_gender', ['male', 'female', 'other'])->nullable()->after('receiver_country');
            $table->string('sender_name')->nullable()->after('receiver_gender');
            $table->enum('delivery_method', ['home_delivery', 'store_pickup'])->default('home_delivery')->after('sender_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'receiver_house_number',
                'receiver_street',
                'receiver_city',
                'receiver_state',
                'receiver_zip',
                'receiver_country',
                'receiver_gender',
                'sender_name',
                'delivery_method',
            ]);
        });
    }
};
