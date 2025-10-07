<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'tbl_blogs';

    protected $primaryKey = 'id';

    protected $fillable = [
        'blog_title',
        'description',
        'blog_image',
        'publish_date',
        'is_active',
        'is_deleted',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
    ];
}
