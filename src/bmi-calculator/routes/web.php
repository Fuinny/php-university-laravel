<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BmiController;

Route::get('/bmi', [BmiController::class, 'index']);
Route::post('/bmi', [BmiController::class, 'calculate']);
