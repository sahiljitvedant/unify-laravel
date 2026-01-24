<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('job_applications', function (Blueprint $table) {
        $table->index('city');
        $table->index('job_title');
        $table->index(['city', 'job_title']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropIndex(['city']);
            $table->dropIndex(['job_title']);
            $table->dropIndex(['city', 'job_title']);
        });
    }
};
