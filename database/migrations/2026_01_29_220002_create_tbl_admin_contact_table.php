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
        Schema::create('tbl_admin_contact', function (Blueprint $table) {
            $table->id();
            $table->text('youtube_url')->nullable();
            $table->text('facebook_url')->nullable();
            $table->text('linkedin_url')->nullable();
            $table->text('instagram_url')->nullable();
            $table->string('mobile_number1')->nullable();
            $table->string('mobile_number2')->nullable();
            $table->string('email_address1')->nullable();
            $table->string('email_address2')->nullable();
            $table->string('business_hours')->nullable();
            $table->text('business_day')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_admin_contact');
    }
};
