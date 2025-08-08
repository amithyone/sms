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
            $table->string('bracelet_size')->nullable()->after('ring_size');
            $table->string('necklace_length')->nullable()->after('bracelet_size');
            $table->string('material')->nullable()->after('blanket_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customizations', function (Blueprint $table) {
            $table->dropColumn(['bracelet_size', 'necklace_length', 'material']);
        });
    }
};
