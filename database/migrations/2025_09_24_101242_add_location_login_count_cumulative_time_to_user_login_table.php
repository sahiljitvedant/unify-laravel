<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_user_login', function (Blueprint $table) {
            $table->string('location')->nullable()->after('user_id');
            $table->integer('login_count')->default(0)->after('location');
            $table->integer('cumulative_time')->default(0)->after('login_count'); // in minutes
        });
    }

    public function down(): void
    {
        Schema::table('tbl_user_login', function (Blueprint $table) {
            $table->dropColumn(['location', 'login_count', 'cumulative_time']);
        });
    }
};
