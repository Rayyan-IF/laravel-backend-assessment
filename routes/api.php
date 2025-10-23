<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// User API routes
Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);