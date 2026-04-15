<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactModel;


class ContactController extends Controller
{
    public function postContact(Request $request){
        try{
             if(is_null($request->name) || is_null($request->email) || !isset($request->status)){
                return response()->json([
                    "success"=>false,
                    "message"=>"name , email , status is erquire",
                ],400);
            }else{
                ContactModel::create([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'status'=>$request->status,
                    'company'=>$request->company ?? null, 
                ]);

                return response()->json([
                    "success"=>true,
                    "message"=>"contact created successfully",
                ],200);
            }

        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function getContacts(){
        try{
            $contacts = ContactModel::all();

            if($contacts->isEmpty()){

                 return response()->json([
                      "success"=>false,
                    "message"=>"No Contacts found",
                ],400);
            }else{
                     return response()->json([
                    "success"=>true,
                    "message"=>"contacts fetched successfully",
                    "data"=>$contacts,
                ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function updateContact(Request $request , $id){
        try{
            if(!$id){

                 return response()->json([
                    "success"=>true,
                    "message"=>"ID is required",
                ],400);

            }else{
                $contact = ContactModel::find($id);
                if(!$contact){
                return response()->json([
                    "success"=>true,
                    "message"=>"No contact Fpound",
                ],400);
                }

                $contact->update([
                   'name'=>$request->name,
                    'email'=>$request->email,
                    'status'=>$request->status,
                    'company'=>$request->company ?? null, 
                    ]);
                    
                return response()->json([
                    "success"=>true,
                    "message"=>"contact updated successfully",
                    "data"=>$contact,
                ],200);
            }

        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function deleteContact($id){
       try{

        if(!$id){
            return response()->json([
                "success"=>false,
                "message"=>"id is required",
            ],400);
        }

        $contact = ContactModel::find($id);

        if(!$contact){
            return response()->json([
                "success"=>false,
                "message"=>"No contact found",
            ],400);
        }

        $contact->delete();

        return response()->json([
            "success" => true,
            "message" => "contact Deleted Successfully",
        ],200);

       }catch(\Exception $e){

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

        }
    }
}
