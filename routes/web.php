<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

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


Route::resource('properties', PropertyController::class);

Route::get('/create', [PropertyController::class, 'create']);
Route::post('/store', [PropertyController::class, 'store']);
Route::get('/show/{id}', [PropertyController::class, 'show']);
Route::get('/edit/{id}', [PropertyController::class, 'edit']);
Route::put('/update/{id}', [PropertyController::class, 'update']);
Route::post('/delete/{id}', [PropertyController::class, 'destroy']);