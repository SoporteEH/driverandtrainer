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

    Route::get('/jobs/create', function () {
        return view('jobs.create');
    })->name('jobs.create');

    Route::get('/jobs', function () {
        return view('jobs.index');
    })->name('jobs.index');
    
    Route::get('/jobs/{job}', function (App\Models\TransportJob $job) {
        return view('jobs.show', compact('job'));
    })->name('jobs.show');

    Route::get('/jobs/{job}/edit', function (App\Models\TransportJob $job) {
        return view('jobs.edit', compact('job'));
    })->name('jobs.edit')->can('update', 'job');

    Route::delete('/expenses/{expense}', [App\Http\Controllers\ExpenseController::class, 'destroy'])
        ->name('expenses.destroy');
});
