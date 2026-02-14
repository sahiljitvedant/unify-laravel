<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'tbl_testimonials';

    protected $fillable = [
        'profile_pic',
        'name',
        'position',
        'testimonial_text',
        'is_active',
        'is_deleted'
    ];
}
