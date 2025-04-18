<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'otp',
        'password',
        'mobile',
        'profile_pic',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed',
        ];
    }
     // Relationship to posts
   
     public function posts()
     {
         return $this->hasMany(Post::class);
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
 
     // Relationship to notifications
     public function notifications()
     {
         return $this->hasMany(Notification::class);
     }
 }