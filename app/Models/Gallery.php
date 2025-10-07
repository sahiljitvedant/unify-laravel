<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'tbl_gallery'; 

    protected $primaryKey = 'id';

    protected $fillable = [
        'gallery_name',
        'is_active',
        'main_thumbnail',
        'gallery_images',
        'youtube_links',
        'is_deleted',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
        'gallery_images' => 'array', // longtext can be casted as JSON if you store JSON
        'youtube_links' => 'array',
    ];
}
