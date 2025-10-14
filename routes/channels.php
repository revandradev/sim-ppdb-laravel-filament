<?php

use App\Models\User;
use App\Models\UserPendaftaran;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('App.Models.User.{id}', function (User $user, $id) {
    Log::info('Broadcasting channel check for User', ['user_id' => $user->id, 'channel_id' => $id]);
    return (int) $user->id === (int) $id;
});
Broadcast::channel('App.Models.UserPendaftaran.{id}', function (UserPendaftaran $user, int $id): bool {
    Log::info('Broadcasting channel check for UserPendaftaran', ['user_id' => $user->id, 'channel_id' => $id]);
    return $user->id === $id;
}, ['guards' => ['user_pendaftaran']]);
