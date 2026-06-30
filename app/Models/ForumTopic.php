<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    protected $table = 'forum_topics';

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'school_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
