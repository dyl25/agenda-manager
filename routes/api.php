<?php

use App\Http\Controllers\api\ServiceSettingController;
use App\Http\Controllers\api\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/services', [ServiceSettingController::class, 'index'])->name('services.index');
Route::post('/services', [ServiceSettingController::class, 'store'])->name('services.store');

Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');