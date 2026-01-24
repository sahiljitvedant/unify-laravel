<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = 'tbl_careers';

    protected $fillable = [
        'designation',
        'experience',
        'years_of_experience',
        'job_description',
        'location',
        'work_type',
        'status',
        'is_deleted',
    ];
}
