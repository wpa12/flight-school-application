<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index']);

Route::get('/login', [PageController::class, 'login']);

Route::get('/register', [PageController::class, 'register']);