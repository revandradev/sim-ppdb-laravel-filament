<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/push/subscribe', function (Request $request) {
    Log::info('Push subscribe', ['request' => $request->all()]);
    $user = auth()->user();
    if (! $user) {
        abort(403);
    }
    // $request->endpoint, $request->keys['p256dh'], $request->keys['auth']
    $user->updatePushSubscription(
        $request->endpoint,
        $request->keys['p256dh'] ?? null,
        $request->keys['auth'] ?? null,
        $request->keys['contentEncoding'] ?? null
    );
    return response()->json(['success' => true]);
})->name('push.subscribe')->middleware(['auth:user_pendaftaran']);
Route::post('/push/unsubscribe', function (Request $request) {
    $user = auth()->user();
    $user->deletePushSubscription($request->endpoint);
    return response()->json(['success' => true]);
})->middleware(['auth:user_pendaftaran'])->name('push.unsubscribe');
