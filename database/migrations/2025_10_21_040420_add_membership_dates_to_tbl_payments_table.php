<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->date('membership_start_date')->nullable()->after('user_id');
            $table->date('membership_end_date')->nullable()->after('membership_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_payments', function (Blueprint $table) {
            $table->dropColumn(['membership_start_date', 'membership_end_date']);
        });
    }
};
