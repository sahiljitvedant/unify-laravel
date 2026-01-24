<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $table = 'headers';

    protected $fillable = [
        'title',
        'sequence_no',
        'status',
        'is_deleted',
    ];
    public function subheaders()
    {
        return $this->hasMany(SubHeader::class)
            ->where('status', 1)
            ->where('is_deleted', 0)
            ->orderBy('id');
    }

}
