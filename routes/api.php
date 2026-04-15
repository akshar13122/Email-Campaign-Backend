<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usercontroller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about/{name}', function($name){
    return view('first',['name'=>$name]);
});

Route::get('/getusers',[Usercontroller::class,"getUsers"]);
Route::get('/user/{name}',[Usercontroller::class,"printuser"]);
Route::post('/api/postuser', [UserController::class, 'postUser']);


// route::redirect('/about/{name}','/');

// Route::view('/about',"first");