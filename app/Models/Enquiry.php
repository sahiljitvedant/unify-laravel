<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    protected $table = 'tbl_enquiry';
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'header_id',
        'subheader_id',
        'message',
        'request_id',
        'reply',
        'status'
    ];
    
}
