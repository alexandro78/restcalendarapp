<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('calendar', [CalendarController::class, 'getCalendar']);
Route::post('calendar', [CalendarController::class, 'createEntry']);
Route::patch('calendar/{id}', [CalendarController::class, 'updateEntry']);
Route::delete('calendar/{id}', [CalendarController::class, 'deleteEntry']);
// Route::get('calendar/{id}', [CalendarController::class, 'getEntryById']);
