<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_gym_membership', function (Blueprint $table) {
            // Change description to longText
            $table->longText('description')->nullable()->change();

            // Change boolean/tinyInteger fields to ENUM('0','1')
            $table->enum('is_active', ['0', '1'])->default('1')->change();
            $table->enum('is_deleted', ['0', '1'])->default('1')->change();
            $table->enum('trainer_included', ['0', '1'])->default('0')->change();

            // Add indexes only if they do not exist
            if (! $this->indexExists('tbl_gym_membership', 'tbl_gym_membership_membership_name_index')) {
                $table->index('membership_name'); // Laravel will auto-name it
            }

            if (! $this->indexExists('tbl_gym_membership', 'tbl_gym_membership_is_active_index')) {
                $table->index('is_active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tbl_gym_membership', function (Blueprint $table) {
            $table->tinyInteger('is_active')->default(1)->change();
            $table->tinyInteger('is_deleted')->default(0)->change();
            $table->tinyInteger('trainer_included')->default(0)->change();

            // Drop indexes safely if exist
            if ($this->indexExists('tbl_gym_membership', 'tbl_gym_membership_membership_name_index')) {
                $table->dropIndex('tbl_gym_membership_membership_name_index');
            }

            if ($this->indexExists('tbl_gym_membership', 'tbl_gym_membership_is_active_index')) {
                $table->dropIndex('tbl_gym_membership_is_active_index');
            }
        });
    }

    // Helper to check if index exists
    private function indexExists(string $tableName, string $indexName): bool
    {
        $databaseName = env('DB_DATABASE');

        $result = DB::select(
            "SELECT COUNT(1) as IndexIsThere 
            FROM INFORMATION_SCHEMA.STATISTICS 
            WHERE table_schema = ? 
              AND table_name = ? 
              AND index_name = ?",
            [$databaseName, $tableName, $indexName]
        );

        return $result[0]->IndexIsThere > 0;
    }
};
