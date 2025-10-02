<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable()->after('user_id');
            $table->date('membership_start_date')->nullable()->after('plan_id');
            $table->date('membership_end_date')->nullable()->after('membership_start_date');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['plan_id', 'membership_start_date', 'membership_end_date']);
        });
    }
};
