<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_trainer', function (Blueprint $table) {
            // Add column as nullable first to avoid duplicate '' issues
            if (!Schema::hasColumn('tbl_trainer', 'mobile_number')) {
                $table->string('mobile_number', 10)->nullable()->after('trainer_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_trainer', function (Blueprint $table) {
            if (Schema::hasColumn('tbl_trainer', 'mobile_number')) {
                $table->dropColumn('mobile_number');
            }
        });
    }
};
