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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/store', [App\Http\Controllers\TaskController::class,'store'])->name('store');
Route::delete('/destroy', [App\Http\Controllers\TaskController::class,'destroy'])->name('destroy');
Route::put('/update', [App\Http\Controllers\TaskController::class,'update'])->name('update');
