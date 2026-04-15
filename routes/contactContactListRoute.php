<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\contactContactListController;

Route::post('/contact-contact-llist',[contactContactListController::class,'postContactContact']); 
Route::get('contact-contact-llist/{id}',[contactContactListController::class,'getContactContactList']);
Route::delete('contact-contact-llist-delete/{contactId}/{contactListId}',[contactContactListController::class,'deleteContactContactList']);
Route::get('contact-contact-llist-excluded/{id}',[contactContactListController::class,'getRemainingContact']);