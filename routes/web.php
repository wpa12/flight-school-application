<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index']);

Route::get('/aircraft', [PageController::class, 'aircraft'])->name('aircraft');

Route::get('/exams', [PageController::class, 'exams'])->name('exams');

Route::get('/instructors', [PageController::class, 'instructors'])->name('instructors');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [PageController::class, 'register'])->name('register');
    Route::post('/register', [RegistrationController::class, 'register']);
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('bookings/create', [DashboardController::class, 'adminPlaceholder'])->name('bookings.create');
    Route::get('bookings/{booking}/edit', [DashboardController::class, 'adminPlaceholder'])->name('bookings.edit');
    Route::delete('bookings/{booking}', [DashboardController::class, 'adminPlaceholder'])->name('bookings.destroy');

    Route::get('users/create', [DashboardController::class, 'adminPlaceholder'])->name('users.create');
    Route::get('users/{user}/edit', [DashboardController::class, 'adminPlaceholder'])->name('users.edit');

    Route::get('aircraft/create', [DashboardController::class, 'adminPlaceholder'])->name('aircraft.create');
    Route::get('aircraft/{aircraft}/edit', [DashboardController::class, 'adminPlaceholder'])->name('aircraft.edit');
    Route::delete('aircraft/{aircraft}', [DashboardController::class, 'adminPlaceholder'])->name('aircraft.destroy');

    Route::get('instructors/create', [DashboardController::class, 'adminPlaceholder'])->name('instructors.create');
    Route::get('instructors/{instructor}/edit', [DashboardController::class, 'adminPlaceholder'])->name('instructors.edit');
    Route::delete('instructors/{instructor}', [DashboardController::class, 'adminPlaceholder'])->name('instructors.destroy');
});
