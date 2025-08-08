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
        Schema::table('users', function (Blueprint $table) {
            $table->string('registration_ip')->nullable()->after('email_verified_at');
            $table->string('user_agent')->nullable()->after('registration_ip');
            $table->boolean('is_verified')->default(false)->after('user_agent');
            $table->boolean('is_suspicious')->default(false)->after('is_verified');
            $table->timestamp('last_login_at')->nullable()->after('is_suspicious');
            $table->integer('login_attempts')->default(0)->after('last_login_at');
            $table->timestamp('locked_until')->nullable()->after('login_attempts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'registration_ip',
                'user_agent',
                'is_verified',
                'is_suspicious',
                'last_login_at',
                'login_attempts',
                'locked_until'
            ]);
        });
    }
};
