<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_login'; // follow your naming convention

    protected $fillable = [
        'user_id',
        'date',
        'log_in_time',
        'log_out_time',
        'total_time',
        'status',
        'created_by',
        'updated_by',
        'cumulative_time',  // new
        'login_count',      // new
        'location',         // new
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
