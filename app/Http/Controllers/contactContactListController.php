<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactContactListModel;
use App\Models\ContactModel;

class contactContactListController extends Controller
{
public function postContactContact(Request $request){
    try {

        if (!$request->contact_ids || !$request->contact_list_id) {
            return response()->json([
                "success" => false,
                "message" => "contact_ids and contact_list_id are required",
            ], 400);
        }

        foreach ($request->contact_ids as $contactId) {

            ContactContactListModel::create([
                "contact_id" => $contactId,
                "contact_list_id" => $request->contact_list_id,
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Contacts added to list successfully",
        ], 200);

    } catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
}

    public function getContactContactList($id){
        try{
            
        if(!$id){
       return response->json()([
        "success" => true,
        "message" => "Id is Require",
      ],400);
        }else{

            $contactContactLists = ContactContactListModel::with([
                'contact:id,name,email,status,company',
                'contactList:id,list_name'
            ])
            ->where('contact_list_id',$id)
            ->get();

              return response()->json([
            "success" => true,
            "data" => $contactContactLists,
        ], 200);
        }

        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function deleteContactContactList($contactId,$contactListId){
        try{

           if(!$contactId || !$contactListId ){
            return response->json()([
            "success" => true,
            "message" => "Id is Require",
            ],400);

           }else{

            $contactContactList = ContactContactListModel::where
            ('contact_id',$contactId)
            ->where('contact_list_id',$contactListId)
            ->first();

            if(!$contactContactList){
                return response()->json([
                "success"=>false,
                "message"=>"No contact found",
            ],400);
            }

             $contactContactList->delete();

            return response()->json([
            "success" => true,
            "message" => "Contact removed from list successfully",
            ], 200);

        }

        }catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
    }

    public function getRemainingContact($id){
    try {

        // check id
        if (!$id) {
            return response()->json([
                "success" => false,
                "message" => "Id is required",
            ], 400);
        }

        $existingContactIds = ContactContactListModel::where(
            'contact_list_id',
            $id
        )->pluck('contact_id');

        $remainingContacts = ContactModel::whereNotIn(
            'id',
            $existingContactIds
        )
        ->where('status',0)
        ->get();

        return response()->json([
            "success" => true,
            "data" => $remainingContacts,
        ], 200);

        } catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

        }
    }
}
