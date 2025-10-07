<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_preferences';

    protected $fillable = [
        'user_id',
        'preference_id',
        'is_active',
        'status',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to Preference (id -> name)
    public function preference()
    {
        return $this->belongsTo(Preference::class, 'preference_id');
    }
}
