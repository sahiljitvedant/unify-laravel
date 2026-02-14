<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('profile_pic')->nullable();
            $table->string('name', 150);
            $table->string('position', 150)->nullable();
            $table->text('testimonial_text');
            $table->boolean('is_active')->default(1);
            $table->tinyInteger('is_deleted')->default(0); // 0 = normal, 9 = deleted
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_testimonials');
    }
}
