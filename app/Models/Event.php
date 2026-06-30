<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'location',
        'image',
        'school_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function rsvps()
    {
        return $this->hasMany(EventRsvp::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
