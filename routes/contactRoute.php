<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::post('/contact/post',[ContactController::class,"postContact"]);
Route::get('/contact/get',[ContactController::class,"getContacts"]);
Route::put('/updateContact/{id}',[ContactController::class,"updateContact"]);
Route::delete('/deleteContact/{id}',[ContactController::class,"deleteContact"]);
