<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/jobs', [App\Http\Controllers\TransportJobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create', [App\Http\Controllers\TransportJobController::class, 'create'])->name('jobs.create');
    Route::get('/jobs/{job}', [App\Http\Controllers\TransportJobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/{job}/edit', [App\Http\Controllers\TransportJobController::class, 'edit'])->name('jobs.edit');
    Route::delete('/jobs/{job}', [App\Http\Controllers\TransportJobController::class, 'destroy'])->name('jobs.destroy');

    Route::delete('/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'destroy'])
        ->name('expenses.destroy');
});
