<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->decimal('total_amount_paid', 10, 2)->default(0)->after('amount')
                  ->comment('Total amount user has paid so far for the plan');
            $table->decimal('total_amount_remaining', 10, 2)->default(0)->after('total_amount_paid')
                  ->comment('Total remaining balance for the plan');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->dropColumn(['total_amount_paid', 'total_amount_remaining']);
        });
    }
};
