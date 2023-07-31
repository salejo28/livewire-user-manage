<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1/auth')->controller(Auth::class)->group(function() {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout');
    Route::post('/refresh', 'refresh');
});

Route::prefix('v1/users')->controller(User::class)->group(function() {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::put('/{uid}', 'update');
    Route::delete('/{uid}', 'destroy');
});
