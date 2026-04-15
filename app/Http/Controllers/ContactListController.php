<?php

namespace App\Http\Controllers;
use App\Models\ContactListModel;

use Illuminate\Http\Request;

class ContactListController extends Controller
{
    public function postContactList(Request $request){
        try{
            if(!$request->list_name){
                 return response()->json([
                    "success"=>false,
                    "message"=>"contact List is erquire",
                ],400);
            }else{
                ContactListModel::create([
                    'list_name'=>$request->list_name,
                    'description'=>$request->description ?? null,
                ]);
                 return response()->json([
                    "success"=>true,
                    "message"=>"contact List created successfully",
                ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function getContactList(){
        try{
            $contactList = ContactListModel::all();
            if($contactList->isEmpty()){
                 return response()->json([
                    "success"=>false,
                    "message"=>"contact List is Empty",
                ],400);
            }else{
                return response()->json([
                    "success"=>true,
                    "message"=>"contact List Fetched successfully",
                    "data"=>$contactList,
                ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function updateContactList(Request $request , $id){
        try{
            if(!$id){
                 return response()->json([
                    "success"=>false,
                    "message"=>"Id is required",
                ],400);
            }else{
                $contactList = ContactListModel::find($id);
                if(!$contactList){
                     return response()->json([
                    "success"=>false,
                    "message"=>"no contactList found",
                ],400);
                }

                $contactList->update([
                    'list_name'=>$request->list_name,
                    'description'=>$request->description ?? null,
                ]);

                 return response()->json([
                    "success"=>true,
                    "message"=>"contact List Updated successfully",
                    "data" =>  $contactList,
                ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function deleteContactList($id){
        try{
              if(!$id){
                 return response()->json([
                    "success"=>false,
                    "message"=>"Id is required",
                ],400);
                }else{
                     $contactList = ContactListModel::find($id);

                      if(!$contactList){
                     return response()->json([
                    "success"=>false,
                    "message"=>"no contactList found",
                ],400);
                }

                $contactList->delete();
                
                 return response()->json([
                    "success"=>true,
                    "message"=>"contact List Deleted successfully",       
                ],200);

                }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }


    public function getContactListName($id){
        try{
            if(!$id){
                 return response()->json([
                    "success"=>false,
                    "message"=>"id is required",
                ],400);
            }else{
                $contactList = ContactListModel::find($id);

                return response()->json([
                    "success"=>true,
                    "message"=>"List Fetched Successfully",
                    "data"=>$contactList->list_name,
                ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }


}
