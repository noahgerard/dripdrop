<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/comment', [CommentController::class, 'create'])->name('comment.create');
    Route::delete('/comment', [CommentController::class, 'delete'])->name('comment.delete');
});
