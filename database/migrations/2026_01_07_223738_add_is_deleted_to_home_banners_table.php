<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('home_banners', function (Blueprint $table) {
            $table->tinyInteger('is_deleted')
                  ->default(0)
                  ->comment('0 = active, 9 = deleted')
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('home_banners', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
        });
    }
};
