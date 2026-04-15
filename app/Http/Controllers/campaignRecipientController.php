<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignRecipientModel;
use App\Models\CampaignContactListModel;
use App\Models\ContactContactListModel;

class campaignRecipientController extends Controller
{
public function generateRecipients($campaignId)
{
    try {

        if (!$campaignId) {
            return response()->json([
                "success" => false,
                "message" => "Campaign Id is required"
            ], 400);
        }

        // Get contact list ids for this campaign
        $contactListIds = CampaignContactListModel::where(
            'campaign_id',
            $campaignId
        )->pluck('contact_list_id');

        // Get contact ids from those lists
        $contactIds = ContactContactListModel::whereIn(
            'contact_list_id',
            $contactListIds
        )->pluck('contact_id')
         ->unique();

        // Get already existing recipients
        $existingRecipientIds = CampaignRecipientModel::where(
            'campaign_id',
            $campaignId
        )->pluck('contact_id');

        // Remove duplicates
        $newContactIds = $contactIds->diff($existingRecipientIds);

        // Insert recipients
        foreach ($newContactIds as $contactId) {

            CampaignRecipientModel::create([
                "campaign_id" => $campaignId,
                "contact_id" => $contactId,
                "status" => 0
            ]);

        }

        return response()->json([
            "success" => true,
            "message" => "Recipients generated successfully"
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
}


    public function getCampaignStatus($campaignId){
        try{
             if(!$campaignId){
                  return response()->json([
                "success" => false,
                "message" => "Campaign Id is required"
            ], 400);

            }else{
                $total = CampaignRecipientModel::where(
                    'campaign_id', $campaignId
                )->count();

                $pending = CampaignRecipientModel::where(
                    'campaign_id', $campaignId
                )->where('status',0)
                ->count();

                $queued = CampaignRecipientModel::where(
                   'campaign_id', $campaignId
                )->where('status',1)
                ->count();

                $sent = CampaignRecipientModel::where(
                   'campaign_id', $campaignId
                )->where('status',2)
                ->count();

                $failed = CampaignRecipientModel::where(
                   'campaign_id', $campaignId
                )->where('status',3)
                ->count();

                $skipped = CampaignRecipientModel::where(
                   'campaign_id', $campaignId
                )->where('status',4)
                ->count();

                return response()->json([
                "success" => true,
                "data" => [
                "total" => $total,
                'queued' => $queued,
                'pending' => $pending,
                "sent" => $sent,
                "failed" => $failed,
                "skipped" => $skipped
               ]
        ]);
            }
        }catch (\Exception $e) {
        return response()->json([
            "error" => $e->getMessage()
        ], 500);
    }
    }
}
