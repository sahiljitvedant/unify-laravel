<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasFactory;

    protected $table = 'about_pages';

    protected $fillable = [
        'title',
        'slug',
        'header_id',
        'subheader_id',
        
        'description',
        'image',
        'status',
        'is_deleted',
    ];

    // Optional relationships (future use)
    public function header()
    {
        return $this->belongsTo(Header::class);
    }

    public function subheader()
    {
        return $this->belongsTo(SubHeader::class);
    }
}
