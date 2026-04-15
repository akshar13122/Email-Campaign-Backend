<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\campaignController;

Route::post('/campaign/post',[CampaignController::class, 'saveCampaign']);
Route::get('/campaign/get',[CampaignController::class, 'getCampaignData']);
Route::put('/update-campaign/{id}', [CampaignController::class, 'updateCampaign']);
Route::delete('/delete-campaign/{id}', [CampaignController::class, 'deleteCampaign']);
Route::get('/get-campaign/{id}', [CampaignController::class, 'getCampaignById']);

Route::post('/send-campaign/{id}', [CampaignController::class, 'sendCampaign']);