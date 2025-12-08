<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

// Guest routes (not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'getLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'getRegisterForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forget-password', [ForgotPasswordController::class, 'request'])->name('password.request');
    Route::post('/forget-password', [ForgotPasswordController::class, 'email'])->name('password.email');
    Route::post('/reset-password', [ForgotPasswordController::class, 'update'])->name('password.update');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'reset'])->name('password.reset');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/settings', [AuthController::class, 'settings'])->name('auth.settings');

    // Todo routes
    Route::get('/todos/finished', [TodoController::class, 'finished'])->name('todos.finished');
    Route::resource('todos', TodoController::class);
    Route::patch('/todos/{todo}/toggle', [TodoController::class, 'toggleComplete'])->name('todos.toggle');
});

