<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
      protected $fillable = ['user_id', 'title', 'content', 'image', 'visibility'];
    // Relationship to user (belongs to)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('default-image.jpg');
    }
    // Relationship to comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relationship to likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Relationship to bookmarks
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    // Relationship to tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}

