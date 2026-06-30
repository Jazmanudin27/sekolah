<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'primary_color',
        'secondary_color',
        'welcome_headmaster',
        'welcome_alumni',
        'history',
        'vision',
        'mission',
        'address',
        'phone',
        'email',
        'google_maps'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function extracurriculars()
    {
        return $this->hasMany(Extracurricular::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function businesses()
    {
        return $this->hasMany(Business::class);
    }

    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
