<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->enum('admin_approved', [0, 1])
                  ->default(0)
                  ->after('is_deleted'); 
        });
    }

    public function down(): void
    {
        Schema::table('tbl_gym_members', function (Blueprint $table) {
            $table->dropColumn('admin_approved');
        });
    }
};
