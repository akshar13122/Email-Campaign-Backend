<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addUserController;

Route::post('/campaign/add-user',[addUserController::class, 'addUser']);
Route::get('/campaign/get-user',[addUserController::class, 'getUsers']);
Route::put('/campaign/update-user/{id}',[addUserController::class, 'updateUser']);
Route::delete('/campaign/delete-user/{id}',[addUserController::class, 'deleteUser']);
Route::post('/login-user', [addUserController::class, 'loginUser']);