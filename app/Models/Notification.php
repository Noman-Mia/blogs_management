<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Relationship to user (belongs to)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
