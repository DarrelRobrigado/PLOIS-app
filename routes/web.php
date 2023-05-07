<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\LoginController;

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
    return view('index');
});

Route::post('/signin', [SignInController::class, 'signIn']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/login/facebook/callback', 'Auth\LoginController@facebookCallback');

Route::get('/dashboard', function () {
    return view('dashboard');
});




