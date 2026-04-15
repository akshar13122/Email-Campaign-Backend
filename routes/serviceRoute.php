<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\serviceController;

Route::post('/service/post',[serviceController::class,"postService"]);
Route::get('/service/get',[serviceController::class,"getService"]);
Route::post('/updateService/{id}',[serviceController::class,"updateService"]);
Route::post('/deleteService/{id}',[serviceController::class,"deleteService"]);