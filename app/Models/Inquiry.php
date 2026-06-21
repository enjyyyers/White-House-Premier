<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'reply',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function getIsRepliedAttribute()
    {
        return !is_null($this->reply);
    }
}
