<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeSetting extends Model
{
    protected $table = 'tbl_theme_settings';

    protected $fillable = [
        'theme_color',
        'sidebar_color',
        'sidebar_light',
        'other_color_fff',
        'black_color',
        'font_size',
        'font_size_10px',
        'front_font_size',
    ];
}
