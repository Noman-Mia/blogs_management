<?php
namespace App\Models;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model {
    use HasFactory;
    protected $fillable = ['body', 'user_id', 'post_id', 'parent_id'];
    public function user() {
        return $this->belongsTo(User::class);}
    public function post() {
        return $this->belongsTo(Post::class);}
    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');}
    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');}
}