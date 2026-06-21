<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'position',
        'review',
        'rating',
        'image',
        'reply',
        'replied_at',
        'is_active',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'is_active' => 'boolean',
        'rating' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsRepliedAttribute()
    {
        return !is_null($this->reply);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
