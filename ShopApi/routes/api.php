<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\AuthController::class)->prefix('user')->group(function () {

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', 'logout');
    });

    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::controller(\App\Http\Controllers\ProductsController::class)->prefix('product')->group(function () {
    route::get('/search', 'search');
    Route::get('/', 'index');
    Route::get('/{id}', 'show');
    });

Route::middleware('auth:sanctum')->group(function () {

    Route::controller(\App\Http\Controllers\CartsController::class)->prefix('cart')->group(function () {

        Route::get('/', 'index');
        Route::put('/update', 'update');
    });


    Route::controller(\App\Http\Controllers\ProductsController::class)->prefix('product')->group(function () {
        Route::post('/create', 'store');
        Route::put('{id}/update', 'update');
        Route::delete('{id}/delete', 'delete');
    });
});



