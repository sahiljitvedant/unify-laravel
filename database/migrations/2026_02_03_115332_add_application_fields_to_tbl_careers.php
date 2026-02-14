<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tbl_careers', function (Blueprint $table) {
            $table->integer('vacancies')->after('work_type');
            $table->date('application_start_date')->after('vacancies');
            $table->date('application_end_date')->after('application_start_date');
        });
    }

    public function down()
    {
        Schema::table('tbl_careers', function (Blueprint $table) {
            $table->dropColumn([
                'vacancies',
                'application_start_date',
                'application_end_date'
            ]);
        });
    }
};
