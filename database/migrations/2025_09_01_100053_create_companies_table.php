<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_companies', function (Blueprint $table) {
            $table->id();

            $table->string('company_name', 255);
            $table->string('company_mailing_name', 255);
            $table->text('address')->nullable();
            $table->string('country', 100);
            $table->string('pincode', 10)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->string('fax_no', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('website', 255)->nullable();

            $table->date('financial_year');
            $table->date('books_begin');

            $table->string('password')->nullable();
            $table->string('confirm_password')->nullable();

            $table->enum('use_security', ['yes', 'no'])->default('no');
            $table->string('security_password')->nullable();
            $table->string('confirm_security_password')->nullable();

            $table->enum('suffix_symbol', ['yes', 'no'])->default('no');
            $table->enum('space_between', ['yes', 'no'])->default('no');
            $table->enum('show_in_millions', ['yes', 'no'])->default('no');

            $table->unsignedTinyInteger('decimal_places')->default(2);

            $table->boolean('is_deleted')->default(0); // soft delete flag
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_companies');
    }
};
