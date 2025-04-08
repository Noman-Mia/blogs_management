<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id'];
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
    public function bookmarks()
{
    return $this->hasMany(Bookmark::class);
}
}
