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
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->enum('payment_method', ['1', '2', '3'])
                  ->default('1')
                  ->comment('1=Cash, 2=Card, 3=Online')
                  ->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
    }
};
