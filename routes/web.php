<?php

use App\Http\Livewire\Auth;
use App\Http\Livewire\Logout;
use App\Http\Livewire\ShowUsers;
use App\Http\Livewire\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Auth::class);
Route::get('/home', User::class);
Route::get('/logout', Logout::class);