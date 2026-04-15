<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampaignModel;
use App\Jobs\SendCampaignJob;
use App\Models\CampaignContactListModel;

class campaignController extends Controller
{
    public function saveCampaign(Request $request){
        try{

            if (
                !$request->name ||
                !$request->subject ||
                !$request->content ||
                empty($request->contact_list_ids)
            ) {
                return response()->json([
                    "success" => false,
                    "message" => "All fields are required"
                ], 400);
            }

             $campaign = CampaignModel::create([
                "name" => $request->name,
                "subject" => $request->subject,
                "content" => $request->content,
                "status" => 0,
                "scheduled_at" => $request->scheduled_at,
                "queue_name" => null
            ]);

              foreach ($request->contact_list_ids as $listId) {

                CampaignContactListModel::create([
                    "campaign_id" => $campaign->id,
                    "contact_list_id" => $listId
                ]);

            }

            return response()->json([
                "success" => true,
                "message" => "Campaign created successfully"
            ], 200);

        }catch (\Exception $e) {

            return response()->json([
                "error" => $e->getMessage()
            ], 500);

        }
    }

    public function getCampaignData(){
    try {

        $campaigns = CampaignModel::with('contactLists')->get();

        if ($campaigns->isEmpty()) {

            return response()->json([
                "success" => false,
                "message" => "No campaigns found"
            ], 400);

        }

        return response()->json([
            "success" => true,
            "message" => "Campaign data fetched successfully",
            "data" => $campaigns
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
    }

    public function deleteCampaign($id){
    try {

        if (!$id) {
            return response()->json([
                "success" => false,
                "message" => "Campaign Id is required"
            ], 400);
        }

        $campaign = CampaignModel::find($id);

        if (!$campaign) {
            return response()->json([
                "success" => false,
                "message" => "Campaign not found"
            ], 400);
        }

        $campaign->delete();

        return response()->json([
            "success" => true,
            "message" => "Campaign deleted successfully"
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
    }


    public function updateCampaign(Request $request, $id){
    try {

        if (
            !$id ||
            !$request->name ||
            !$request->subject ||
            !$request->content ||
            empty($request->contact_list_ids)
        ) {
            return response()->json([
                "success" => false,
                "message" => "All fields are required"
            ], 400);
        }

        $campaign = CampaignModel::find($id);

        if (!$campaign) {
            return response()->json([
                "success" => false,
                "message" => "Campaign not found"
            ], 400);
        }

        // Update campaign
        $campaign->update([
            "name" => $request->name,
            "subject" => $request->subject,
            "content" => $request->content,
            "scheduled_at" => $request->scheduled_at
        ]);

        // Delete old contact list relations
        CampaignContactListModel::where(
            'campaign_id',
            $id
        )->delete();

        // Insert new contact lists
        foreach ($request->contact_list_ids as $listId) {

            CampaignContactListModel::create([
                "campaign_id" => $id,
                "contact_list_id" => $listId
            ]);

        }
        return response()->json([
            "success" => true,
            "message" => "Campaign updated successfully"
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
   }

   public function getCampaignById($id){
    try{
        if(!$id){
               return response()->json([
                "success" => false,
                "message" => "Id is required"
            ], 400);
        }else{
            $campaign = CampaignModel::with('contactLists')
                       ->where('id',$id)
                       ->first();


            if (!$campaign) {
            return response()->json([
                "success" => false,
                "message" => "Campaign not found"
            ], 404);

        }

        return response()->json([
            "success" => true,
            "message" => "Campaign data fetched successfully",
            "data" => $campaign
        ], 200);         
        }

    }catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
   }

//    public function sendCampaign($id){
//     try {

//         $campaign = CampaignModel::findOrFail($id);

//         /*
//         1 = queued
//         */

//         $campaign->status = 1;
//         $campaign->save();

//         SendCampaignJob::dispatch($campaign->id);

//         return response()->json([
//             "success" => true,
//             "message" => "Campaign queued successfully"
//         ], 200);

//     } catch (\Exception $e) {

//         return response()->json([
//             "error" => $e->getMessage()
//         ], 500);

//     }
//     }


    
    public function sendCampaign($id){
    try {

        $campaign = CampaignModel::findOrFail($id);

        /*
        1 = queued
        */

        $campaign->status = 1;

        /*
        Create dedicated queue name
        Example:
        campaign-15
        */

        $queueName = 'campaign-' . $campaign->id;

        /*
        Store queue name in database
        */

        $campaign->queue_name = $queueName;

        $campaign->save();

        /*
        Dispatch job to dedicated queue
        */

        SendCampaignJob::dispatch($campaign->id);
            // ->onQueue($queueName);

        return response()->json([
            "success" => true,
            "message" => "Campaign queued successfully"
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
}





//     public function sendCampaign($id){
//     try {

//         $campaign = CampaignModel::findOrFail($id);

//         /*
//         1 = queued
//         */

//         $campaign->status = 1;

//         // Dedicated queue per campaign
//         $queueName = 'campaign-' . $campaign->id;

//         $campaign->queue_name = $queueName;

//         $campaign->save();

//         SendCampaignJob::dispatch($campaign->id)
//             ->onQueue($queueName);

//         return response()->json([
//             "success" => true,
//             "message" => "Campaign queued successfully"
//         ], 200);

//     } catch (\Exception $e) {

//         return response()->json([
//             "error" => $e->getMessage()
//         ], 500);

//     }
//    }
}
