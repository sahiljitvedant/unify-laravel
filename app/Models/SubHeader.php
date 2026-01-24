<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubHeader extends Model
{
    protected $table = 'subheaders';
    use HasFactory;

    protected $fillable = [
        'header_id',
        'name',
        'status',
        'is_deleted',
    ];

    public function header()
    {
        return $this->belongsTo(Header::class);
    }
}
