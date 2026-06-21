<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Conversation;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{id}', function ($user, $id) {
    $conversation = Conversation::find($id);
    if (!$conversation) return false;
    return (int) $user->id === (int) $conversation->user_id || $user->role === 'admin';
});

Broadcast::channel('inquiry.{id}', function ($user, $id) {
    return $user->role === 'admin';
});
