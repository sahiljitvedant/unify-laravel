<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportUser extends Model
{
    use HasFactory;

    protected $table = 'tbl_import_users';

    protected $fillable = [
        'first_name',
        'middle_name',
        'email',
        'mobile',
        'password',
    ];

    protected $hidden = ['password'];
}
