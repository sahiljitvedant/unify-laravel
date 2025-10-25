<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'tbl_gym_membership';

    protected $fillable = [
        'membership_name',
        'description',
        'duration_in_days',
        'price',
        'trainer_included',
        'facilities_included',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'facilities_included' => 'array', // since it’s stored as JSON
        'is_active' => 'boolean',
    ];
}
