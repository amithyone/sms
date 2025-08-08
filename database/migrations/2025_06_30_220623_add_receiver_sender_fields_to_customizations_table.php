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
        Schema::table('customizations', function (Blueprint $table) {
            $table->string('sender_name')->nullable()->after('blanket_size');
            $table->string('receiver_name')->nullable()->after('sender_name');
            $table->enum('receiver_gender', ['male', 'female', 'other'])->nullable()->after('receiver_name');
            $table->string('receiver_phone')->nullable()->after('receiver_gender');
            $table->string('receiver_note', 100)->nullable()->after('receiver_phone');
            $table->enum('delivery_method', ['home_delivery', 'store_pickup'])->default('home_delivery')->after('receiver_note');
            $table->string('receiver_address')->nullable()->after('delivery_method');
            $table->string('receiver_zip')->nullable()->after('receiver_address');
            $table->string('receiver_city')->nullable()->after('receiver_zip');
            $table->string('receiver_street')->nullable()->after('receiver_city');
            $table->string('receiver_house_number')->nullable()->after('receiver_street');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customizations', function (Blueprint $table) {
            $table->dropColumn([
                'sender_name',
                'receiver_name',
                'receiver_gender',
                'receiver_phone',
                'receiver_note',
                'delivery_method',
                'receiver_address',
                'receiver_zip',
                'receiver_city',
                'receiver_street',
                'receiver_house_number',
            ]);
        });
    }
};
