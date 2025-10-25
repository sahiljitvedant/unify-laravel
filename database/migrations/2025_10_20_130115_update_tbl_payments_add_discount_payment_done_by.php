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
            // Drop columns
            if (Schema::hasColumn('tbl_payments', 'membership_start_date')) {
                $table->dropColumn('membership_start_date');
            }
            if (Schema::hasColumn('tbl_payments', 'membership_end_date')) {
                $table->dropColumn('membership_end_date');
            }

            // Add new columns
            $table->decimal('discount', 10, 2)->default(0)->after('amount');
            $table->unsignedBigInteger('payment_done_by')->nullable()->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_payments', function (Blueprint $table) {
            // Add dropped columns back
            $table->date('membership_start_date')->nullable()->after('plan_id');
            $table->date('membership_end_date')->nullable()->after('membership_start_date');

            // Drop newly added columns
            $table->dropColumn('discount');
            $table->dropColumn('payment_done_by');
        });
    }
};
