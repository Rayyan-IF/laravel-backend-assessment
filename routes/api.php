<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// User API routes
Route::post('/users', [UserController::class, 'store']);