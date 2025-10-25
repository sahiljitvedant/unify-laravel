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
        'payment_status', 
        'currency',
        'status',        
        'total_amount_paid',
        'total_amount_remaining',
        'discount',         
        'payment_done_by',  
        'membership_start_date',
        'membership_end_date',
        'cycle_id',
        'payment_method'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function membership()
    {
        return $this->belongsTo(Membership::class, 'plan_id'); 
    }

    public function doneByUser()
    {
        return $this->belongsTo(User::class, 'payment_done_by');
    }

}
