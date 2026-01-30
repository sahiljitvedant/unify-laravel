<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminContact extends Model
{
    protected $table = 'tbl_admin_contact';

    protected $fillable = [
        'youtube_url',
        'facebook_url',
        'linkedin_url',
        'instagram_url',
        'mobile_number1',
        'mobile_number2',
        'email_address1',
        'email_address2',
        'business_hours',
        'business_day',
    ];
}
