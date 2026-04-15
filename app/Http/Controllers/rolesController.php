<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RolesModel;

class rolesController extends Controller{
    public function createRoles(Request $request){
        try{
            if(!$request->role){
                return response()->json([
                    "success"=>false,
                    "message"=>"role name is erquire",
                ],400);
            }else{
                RolesModel::create([
                    'role'=>$request->role,
                ]);

                return response()->json([
                    "success"=>true,
                    "message"=>"Role Created Successfully",
                ],200);
            }

        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function getRoles(){
        try{
            $roles = RolesModel::all();

            if($roles->isEmpty()){
                return response()->json([
                    "succes"=>false,
                    "message"=>"no roles found",
                ],400);
            }else{
                return response()->json([
                    "success"=>true,
                    "message"=>"Roles Fetched Successfully",
                    "data"=>$roles,
                ],200);
            }
        }catch(\Exception $e){
            return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function editRole(Request $request,$id){
        try{
            if(!$id){
                return response()->json([
                    "success" => false,
                    "message" => "roleid is required"
                ],400);
            }else{
                $role = RolesModel::find($id);
                if(!$role){
                    return response()->json([
                        "success"=>false,
                        "message"=>"no role foubnd with this id",
                    ],400);
                }

                $role->update([
                    'role' => $request->role,
                ]);

                return response()->json([
                    "success"=>true,
                    "message"=>"role updated successfully",
                    "data"=>$role,
                   
                ],200);
            }
        }catch(\Exception $e){
            return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function deleteRole($id){
        try{
            if(!$id){
                return response()->json([
                    "success"=>false,
                    "message"=>"id is required",
                ],400);
            }else{
                $role = RolesModel::find($id);
                if(!$role){
                    return response()->json([
                        
                    "success"=>false,
                    "message"=>"no role found",
                    ],400);
                }
                $role->delete();
                      return response()->json([
          "success" => true,
          "message" => "Role Deleted Successfully",
          ],200);
            }
        }catch(\Exception $e){
            return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }
}