<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Relationship to user (belongs to)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to post (belongs to)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Relationship to replies (self-referencing)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
