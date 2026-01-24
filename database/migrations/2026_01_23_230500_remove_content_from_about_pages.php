<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE about_pages
            DROP COLUMN content
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE about_pages
            ADD content LONGTEXT NOT NULL
        ");
    }
};
