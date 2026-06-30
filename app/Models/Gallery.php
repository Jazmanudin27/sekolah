<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'title',
        'type',
        'url',
        'category',
        'school_id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
