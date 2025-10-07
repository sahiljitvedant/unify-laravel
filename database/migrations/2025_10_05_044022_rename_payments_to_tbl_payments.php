<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ✅ Rename existing payments table to tbl_payments
        Schema::rename('payments', 'tbl_payments');

        // ✅ Add new column: status (1 = Pending, 2 = Completed)
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->tinyInteger('payment_status')
                ->default(1)
                ->comment('1 = Pending, 2 = Completed')
                ->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::rename('tbl_payments', 'payments');
    }
};
