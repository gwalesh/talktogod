<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'age',
        'religion',
        'denomination',
        'spiritual_background',
        'prayer_requests',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 