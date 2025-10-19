<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'tbl_users';
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function gymMembers()
    {
        return $this->hasMany(GymMember::class, 'user_id');
    }
    public function getProfileCompletionAttribute()
    {
        $member = $this->gymMembers()->first(); // assuming 1:1 relationship, otherwise pick the correct one
        if (!$member) return 0;
    
        $fields = [
            'profile_image'       => 10,
            'first_name'          => 10,
            'middle_name'         => 10,
            'last_name'           => 10,
            'dob'                 => 10,
            'gender'              => 0,
            'email'               => 10, // keep email from User
            'mobile'              => 10,
            'residence_address'   => 5,
            'residence_area'      => 5,
            'zipcode'             => 5,
            'city'                => 5,
            'state'               => 5,
            'country'             => 5,
        ];
    
        $completed = 0;
    
        foreach ($fields as $field => $weight) {
            if ($field == 'email') {
                if (!empty($this->$field)) $completed += $weight;
            } else {
                if (!empty($member->$field)) $completed += $weight;
            }
        }
    
        return $completed;
    }
    
}
