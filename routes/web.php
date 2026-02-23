<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('admin/users', 'admin.users')
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.users');

require __DIR__.'/settings.php';
