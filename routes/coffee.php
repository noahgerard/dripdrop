<?php

use App\Http\Controllers\CoffeeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/coffee', [CoffeeController::class, 'create'])->name('coffee.create');
    Route::delete('/coffee', [CoffeeController::class, 'delete'])->name('coffee.delete');
});
