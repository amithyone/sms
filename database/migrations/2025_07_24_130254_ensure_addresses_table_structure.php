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
        Schema::table('addresses', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('addresses', 'phone')) {
                $table->string('phone')->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('addresses', 'label')) {
                $table->string('label')->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('addresses', 'is_default')) {
                $table->boolean('is_default')->default(false)->after('label');
            }
            
            if (!Schema::hasColumn('addresses', 'address_line_2')) {
                $table->string('address_line_2')->nullable()->after('address_line_1');
            }
            
            // Ensure required columns exist with proper types
            if (!Schema::hasColumn('addresses', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade')->after('id');
            }
            
            if (!Schema::hasColumn('addresses', 'name')) {
                $table->string('name')->after('user_id');
            }
            
            if (!Schema::hasColumn('addresses', 'address_line_1')) {
                $table->text('address_line_1')->after('name');
            }
            
            if (!Schema::hasColumn('addresses', 'city')) {
                $table->string('city')->after('address_line_2');
            }
            
            if (!Schema::hasColumn('addresses', 'state')) {
                $table->string('state')->after('city');
            }
            
            if (!Schema::hasColumn('addresses', 'postal_code')) {
                $table->string('postal_code')->after('state');
            }
            
            if (!Schema::hasColumn('addresses', 'country')) {
                $table->string('country', 2)->after('postal_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            // Remove columns in reverse order
            $table->dropColumn(['phone', 'label', 'is_default', 'address_line_2']);
        });
    }
};
