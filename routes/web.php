<?php

use App\Http\Controllers\AircraftController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;

// public routes
Route::get('/', [PageController::class, 'index']);
Route::get('/aircraft', [PageController::class, 'aircraft'])->name('aircraft');
Route::get('/exams', [PageController::class, 'exams'])->name('exams');
Route::get('/instructors', [PageController::class, 'instructors'])->name('instructors');

// guest routes
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [PageController::class, 'register'])->name('register');
    Route::post('/register', [RegistrationController::class, 'register']);
});

// authenticated routes
Route::middleware(['auth'])->group(function (): void {
    Route::prefix('dashboard')->name('dashboard.')->group(function (): void {
        
        // dashboard index route
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        
        // booking dashboard routes
        Route::prefix('bookings')->name('bookings.')->group(function (): void {
            Route::get('/create', [BookingController::class, 'create'])->name('create');
            Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
            Route::post('/create', [BookingController::class, 'store'])->name('store');
            Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit')->middleware('admin');
            Route::put('/{booking}', [BookingController::class, 'update'])->name('update')->middleware('admin');
            Route::delete('/{booking}', [BookingController::class, 'cancel'])->name('cancel');
        });
        
        // user dashboard routes
        Route::prefix('users')->name('users.')->middleware('admin')->group(function (): void {
            Route::get('/create', [DashboardController::class, 'adminPlaceholder'])->name('create');
            Route::get('/{user}/edit', [DashboardController::class, 'adminPlaceholder'])->name('edit');
        });
        
        // aircraft dashboard routes
        Route::prefix('aircraft')->name('aircraft.')->middleware('admin')->group(function (): void {
            Route::get('/create', [AircraftController::class, 'create'])->name('create');
            Route::post('/create', [AircraftController::class, 'store'])->name('store');
            Route::get('/{aircraft}', [AircraftController::class, 'show'])->name('show');
            Route::put('/{aircraft}', [AircraftController::class, 'update'])->name('update');
            Route::get('/{aircraft}/edit', [AircraftController::class, 'edit'])->name('edit');
            Route::delete('/{aircraft}', [AircraftController::class, 'delete'])->name('delete');
        });
        
        // instructor dashboard routes
        Route::prefix('instructors')->name('instructors.')->middleware('admin')->group(function (): void {
            Route::get('/create', [DashboardController::class, 'adminPlaceholder'])->name('create');
            Route::get('/{instructor}/edit', [DashboardController::class, 'adminPlaceholder'])->name('edit');
            Route::delete('/{instructor}', [DashboardController::class, 'adminPlaceholder'])->name('destroy');
        });

        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
