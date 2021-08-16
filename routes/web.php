<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', function () {
    return view('layouts.app');
})->middleware('auth');

Route::get('/vehicles', '\App\Http\Controllers\VehicleController@index');
Route::post('/vehicles/add', '\App\Http\Controllers\VehicleController@store');
Route::get('/vehicles/{id}', '\App\Http\Controllers\VehicleController@details');
Route::post('/vehicles/{id}', '\App\Http\Controllers\VehicleController@save');
Route::post('/vehicles/{id}/delete', '\App\Http\Controllers\VehicleController@delete');

Route::get('/workers', '\App\Http\Controllers\WorkerController@index');
Route::get('/workers/{id}', '\App\Http\Controllers\WorkerController@details');
Route::post('/workers/{id}/save', '\App\Http\Controllers\WorkerController@save');
Route::post('/workers/{id}/delete', '\App\Http\Controllers\WorkerController@delete');

Route::get('/settings', '\App\Http\Controllers\SettingsController@index');
Route::post('/settings/save', '\App\Http\Controllers\SettingsController@save');