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
Route::post('/postuser', [Usercontroller::class, 'postUser']);
Route::post('/updateuser/{id}',[Usercontroller::class,'updateUser']);
Route::post('deleteuser/{id}',[Usercontroller::class,'deleteUser']);
Route::get('/getusers', [Usercontroller::class, 'getAllUsers']);
Route::post('/createProject',[Usercontroller::class,"createProject"]);
Route::get('/getprojects',[Usercontroller::class,"getProjects"]);

// route::redirect('/about/{name}','/');

// Route::view('/about',"first");