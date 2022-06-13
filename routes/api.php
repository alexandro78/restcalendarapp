<?php

use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/logout', [UserController::class, 'logout'] )->name('logout.api');
    Route::get('/user', [UserController::class, 'userData'] )->name('user.api');
    Route::get('calendar', [CalendarController::class, 'getCalendar']);
    Route::patch('calendar/{id}', [CalendarController::class, 'updateEntry']);
    Route::delete('calendar/{id}', [CalendarController::class, 'deleteEntry']);
});

Route::post('/register', [RegisterController::class, 'register'] )->name('register.api');
Route::post('/login', [LoginController::class, 'login'] )->name('login.api');

Route::post('calendar', [CalendarController::class, 'createEntry']);
Route::get('checktest', [CalendarController::class, 'checkUser']);

// Route::get('calendar/{id}', [CalendarController::class, 'getEntryById']);
// Route::post('/tokens/create', [CalendarController::class, 'createToken']);