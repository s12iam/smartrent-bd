<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add the new columns if they don't exist
            if (!Schema::hasColumn('users', 'nid_number')) {
                $table->string('nid_number')->nullable();
            }

            if (!Schema::hasColumn('users', 'mobile_number')) {
                $table->string('mobile_number')->nullable();
            }

            if (!Schema::hasColumn('users', 'optional_mobile')) {
                $table->string('optional_mobile')->nullable();
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable();
            }

            if (!Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable();
            }

            // Only add 'role' column if it doesn't already exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('tenant');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nid_number', 'mobile_number', 'optional_mobile', 'address', 'profile_photo', 'role']);
        });
    }
};