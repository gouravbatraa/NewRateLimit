<?php

use App\Http\Controllers\RateLimitController;
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

Route::get('/', function () {
    return view('welcome');
});

//check session from ip address
Route::middleware('rate.limit')->group(function () {
    Route::get('/check-ip-address', [RateLimitController::class, 'checkRateLimit'])->name('ip-address');
    Route::get('/create-session', [RateLimitController::class, 'createSession'])->name('create-session');
});
