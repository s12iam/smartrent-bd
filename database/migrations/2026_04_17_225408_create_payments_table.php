<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('bookings', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_method');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('bookings', 'payment_method')) {
                $columns[] = 'payment_method';
            }

            if (Schema::hasColumn('bookings', 'paid_at')) {
                $columns[] = 'paid_at';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};