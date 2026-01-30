<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tbl_enquiry', function (Blueprint $table) {
    
            // 1️⃣ Add mobile
            if (!Schema::hasColumn('tbl_enquiry', 'mobile')) {
                $table->string('mobile')->nullable()->after('email');
            }
    
            // 2️⃣ Add header_id FIRST
            if (!Schema::hasColumn('tbl_enquiry', 'header_id')) {
                $table->unsignedBigInteger('header_id')->nullable()->after('mobile');
            }
    
            // 3️⃣ Add subheader_id AFTER header_id exists
            if (!Schema::hasColumn('tbl_enquiry', 'subheader_id')) {
                $table->unsignedBigInteger('subheader_id')->nullable()->after('header_id');
            }
    
            // 4️⃣ Foreign keys
            $table->foreign('header_id')
                  ->references('id')->on('headers')
                  ->nullOnDelete();
    
            $table->foreign('subheader_id')
                  ->references('id')->on('subheaders')
                  ->nullOnDelete();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('tbl_enquiry', function (Blueprint $table) {
            $table->dropForeign(['header_id']);
            $table->dropForeign(['subheader_id']);
            $table->dropColumn(['mobile', 'header_id', 'subheader_id']);
        });
    }
};
