<?php

use App\Http\Controllers\CoffeeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/coffee/{id}', [CoffeeController::class, 'view'])->name('coffee.view');
    // Create coffee page
    Route::get('/coffee', [CoffeeController::class, 'form'])->name('coffee.form');
    Route::post('/coffee', [CoffeeController::class, 'create'])->name('coffee.create');
    Route::delete('/coffee', [CoffeeController::class, 'delete'])->name('coffee.delete');
});
