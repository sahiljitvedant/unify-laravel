<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'tbl_payments'; // use your renamed table

    protected $fillable = [
        'user_id',
        'plan_id',
        'membership_start_date',
        'membership_end_date',
        'payment_id',
        'order_id',
        'signature',
        'gateway',
        'invoice_number',
        'amount',
        'payment_status', // 1 = Pending, 2 = Completed
        'currency',
        'status',         // enum('pending','success','failed')
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
