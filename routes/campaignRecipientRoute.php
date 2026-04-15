<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\campaignRecipientController;

Route::post('/campaign/generate-recipients/{id}',[campaignRecipientController::class, 'generateRecipients']);
Route::get('/campaign/get-recipients/{id}',[campaignRecipientController::class, 'getCampaignStatus']);