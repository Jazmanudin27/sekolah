<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'mentor',
        'image',
        'school_id',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
