<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->oldest();
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function getUnreadCountAttribute()
    {
        return $this->messages()->whereNull('read_at')->count();
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}
