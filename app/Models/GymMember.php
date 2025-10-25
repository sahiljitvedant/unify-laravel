<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymMember extends Model
{
    use HasFactory;

    // Table name (because it's not the default plural of the model name)
    protected $table = 'tbl_gym_members';

    // Primary Key (defaults to id, so no need to change unless different)
    protected $primaryKey = 'id';

    // Mass-assignable columns
    protected $fillable = [
        'user_id',   
        'is_deleted',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'gender',
        'email',
        'mobile',
        'residence_address',
        'residence_area',
        'zipcode',
        'city',
        'state',
        'country',
        'membership_type',
        'joining_date',
        'expiry_date',
        'amount_paid',
        'payment_method',
        'trainer_assigned',
        'fitness_goals',
        'preferred_workout_time',
        'current_weight',
        'additional_notes',
        'profile_image',
        'manual_payment_flag',
        'cron_flag'
    ];

    // Casts for better handling
    protected $casts = [
        'dob'               => 'date',
        'joining_date'      => 'date',
        'expiry_date'       => 'date',
        'current_weight'    => 'decimal:2',
        'amount_paid'       => 'decimal:2',
        'is_deleted'        => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_type'); // membership_type is foreign key
    }
}
