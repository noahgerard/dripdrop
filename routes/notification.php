<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::middleware('auth')->group(function () {
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/{notification}', 'markAsRead')->name('markAsRead');
        Route::patch('/mark-all', 'markAllAsRead')->name('markAllAsRead');
    });
});
