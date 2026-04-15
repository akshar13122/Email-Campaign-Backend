<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\rolesController;

Route::post('/roles/post',[rolesController::class,"createRoles"]);
Route::get('/roles/get',[rolesController::class,"getRoles"]);
Route::post('/updateRoute/{id}',[rolesController::class,"editRole"]);
Route::post('/deleteRoute/{id}',[rolesController::class,"deleteRole"]); 