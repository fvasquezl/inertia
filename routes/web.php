<?php

use Inertia\Inertia;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Products\ProductController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::resource('users', UserController::class)->names('users');
        Route::resource('products', ProductController::class)->names('products');
    });


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
