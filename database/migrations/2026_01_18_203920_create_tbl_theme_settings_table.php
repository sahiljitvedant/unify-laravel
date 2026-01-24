<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_theme_settings', function (Blueprint $table) {
            $table->id();

            $table->string('theme_color')->default('#d9f1e2');
            // Datatable Header, Sidebar, Add button, breadcrumb, submit button

            $table->string('sidebar_color')->default('#009D9D');
            // Sidebar menu color, button color, select dropdown bg

            $table->string('sidebar_light')->default('#85d1d1');

            $table->string('other_color_fff')->default('#fff');

            $table->string('black_color')->default('#000');

            $table->string('font_size')->default('12px');
            $table->string('font_size_10px')->default('10px');
            $table->string('front_font_size')->default('14px');

            $table->timestamps();
        });

        // ✅ Insert default row (IMPORTANT)
        DB::table('tbl_theme_settings')->insert([
            'theme_color'        => '#d9f1e2',
            'sidebar_color'      => '#009D9D',
            'sidebar_light'      => '#85d1d1',
            'other_color_fff'    => '#fff',
            'black_color'        => '#000',
            'font_size'          => '12px',
            'font_size_10px'     => '10px',
            'front_font_size'    => '14px',
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_theme_settings');
    }
};
