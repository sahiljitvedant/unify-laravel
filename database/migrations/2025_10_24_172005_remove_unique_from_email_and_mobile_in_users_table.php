<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_import_users', function (Blueprint $table) {
            // Remove unique indexes if they exist
            $table->dropUnique(['email']);
            $table->dropUnique(['mobile']);
        });
    }

    public function down(): void
    {
        Schema::table('tbl_import_users', function (Blueprint $table) {
            // Re-add unique constraints if you rollback
            $table->unique('email');
            $table->unique('mobile');
        });
    }
};
