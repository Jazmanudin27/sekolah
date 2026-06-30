<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationTransaction extends Model
{
    protected $table = 'donation_transactions';

    protected $fillable = [
        'donation_id',
        'user_id',
        'amount',
        'donor_name',
        'status',
        'payment_method',
        'message',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
