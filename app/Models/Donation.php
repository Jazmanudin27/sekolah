<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'target_amount',
        'raised_amount',
        'type',
        'image',
        'school_id',
    ];

    public function transactions()
    {
        return $this->hasMany(DonationTransaction::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
