<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'name',
        'email',
        'phone',
        'previous_school',
        'major_choice',
        'status',
        'school_id',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->registration_number)) {
                $year = date('Y');
                $latest = static::where('school_id', $model->school_id)
                                ->where('registration_number', 'LIKE', 'PPDB-' . $year . '-%')
                                ->latest()
                                ->first();
                $num = 1;
                if ($latest) {
                    $parts = explode('-', $latest->registration_number);
                    $num = ((int) end($parts)) + 1;
                }
                $model->registration_number = 'PPDB-' . $year . '-' . str_pad($num, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
