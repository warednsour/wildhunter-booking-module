<?php

use App\Http\Controllers\GuideController;
use App\Http\Controllers\HuntingBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/guides', [GuideController::class, 'index']);
Route::post('/bookings', [HuntingBookingController::class, 'store']);
