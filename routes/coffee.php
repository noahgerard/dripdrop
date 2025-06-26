<?php

use App\Http\Controllers\CoffeeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // View a coffee log
    Route::get('/coffee/{id}', [CoffeeController::class, 'view'])->name('coffee.view');

    // Coffee creation
    Route::get('/coffee', [CoffeeController::class, 'form'])->name('coffee.form');
    Route::post('/coffee', [CoffeeController::class, 'create'])->name('coffee.create');

    // Coffee editing
    Route::get('/coffee/{id}/edit', [CoffeeController::class, 'editForm'])->name('coffee.editForm');
    Route::patch('/coffee/edit', [CoffeeController::class, 'edit'])->name('coffee.edit');

    // Coffee deletion
    Route::delete('/coffee', [CoffeeController::class, 'delete'])->name('coffee.delete');
});
