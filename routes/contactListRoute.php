<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactListController;

Route::post('/contact-list/post',[ContactListController::class,"postContactList"]);
Route::get('/contact-list/get',[ContactListController::class,"getContactList"]);
Route::get('/contact-list-by-id/get/{id}',[ContactListController::class,"getContactListName"]);
Route::put('/update-contact-list/{id}',[ContactListController::class,"updateContactList"]);
Route::delete('/delete-contact-list/{id}',[ContactListController::class,"deleteContactList"]);