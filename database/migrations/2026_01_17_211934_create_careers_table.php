<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_careers', function (Blueprint $table) {
            $table->id();

            $table->string('designation');                // Job title
            $table->string('experience')->nullable();     // e.g. "2–4 Years"
            $table->integer('years_of_experience');       // numeric value
            $table->text('job_description');              // full JD
            $table->string('location')->nullable();       // city / remote
            $table->enum('work_type', ['wfo', 'wfh', 'remote']);

            $table->boolean('status')->default(1);        // active/inactive
            $table->tinyInteger('is_deleted')->default(0); // 0 = active, 9 = deleted

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_careers');
    }
};
