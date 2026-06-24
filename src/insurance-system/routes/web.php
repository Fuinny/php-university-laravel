<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\LangController;

Route::group(['middleware' => ['lang']], function () {
    Auth::routes();

    Route::get('/changeLanguage/{lang}', [LangController::class, 'changeLanguage'])->name('lang.changeLanguage');

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        Route::get('/owners', [OwnerController::class, 'index'])->name('owners.index');

        Route::resource('cars', CarController::class)->only(['index']);

        Route::group(['middleware' => ['auth']], function () {
            Route::get('/owners/create', [OwnerController::class, 'create'])->name('owners.create');
            Route::post('/owners', [OwnerController::class, 'store'])->name('owners.store');
            Route::get('/owners/{owner}/edit', [OwnerController::class, 'edit'])->name('owners.edit');
            Route::put('/owners/{owner}', [OwnerController::class, 'update'])->name('owners.update');
            Route::delete('/owners/{owner}', [OwnerController::class, 'destroy'])->name('owners.destroy');

            Route::resource('cars', CarController::class)->except(['index']);

            Route::delete('/cars/photos/{photo}', [CarController::class, 'destroyPhoto'])->name('cars.photos.destroy');
        });
    });
});
