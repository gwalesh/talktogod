<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_type',
        'payment_id',
        'payment_status',
        'subscription_start',
        'subscription_end',
        'amount',
        'currency',
    ];

    protected $casts = [
        'subscription_start' => 'datetime',
        'subscription_end' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->subscription_end && $this->subscription_end->isFuture();
    }

    public function isPremium()
    {
        return $this->plan_type === 'premium' && $this->isActive();
    }
} 