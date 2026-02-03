<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', [HealthController::class, 'check']);

Route::post('/auth/register', [AuthController::class, 'register']);
