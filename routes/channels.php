<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Channel untuk notifikasi realtime
Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Channel untuk chat/diskusi
Broadcast::channel('chat.{roomId}', function ($user, $roomId) {
    // Cek apakah user memiliki akses ke room chat
    return true; // Untuk sementara izinkan semua
});

// Channel khusus admin
Broadcast::channel('admin.notifications', function ($user) {
    return $user->role === 'admin';
});

// Channel khusus bidan
Broadcast::channel('bidan.notifications', function ($user) {
    return $user->role === 'bidan';
});

// Channel khusus kader
Broadcast::channel('kader.notifications', function ($user) {
    return $user->role === 'kader';
});