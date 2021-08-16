<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/booking/{any}', function() {
   // dd(converStringTime('06:71'), converStringTime('23:69'));
    return view('layouts.app-vue-front');
})->where('any', '.*');

Route::get('/admin/{any}', function () {
    return view('layouts.admin.app-vue-admin');
})->where('any', '.*');
