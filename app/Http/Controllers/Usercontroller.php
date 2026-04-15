<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empuser;
use App\Models\Project;

class Usercontroller extends Controller
{
  function getUsers(){
    return "My first Controller to get users";
  }

  function printuser($name){
    return "hello name is". $name;
  }


  public function postUser(Request $request){ 
    try{

     if(!$request->name  || !$request->email || !$request->password){

      return response()->json([
        "success" => false,
        "message" => "All fields are requure",
      ],400);

     }else{

          Empuser::create([

        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password,

      ]);

      return response()->json([
        "success"=>true,
        "message"=>"user created successfuly",
      ],200);
     }
    }catch(\Exception $e){
        return response()->json([
            "error" => $e->getMessage()
        ], 500);
    }
  }

  
 public function updateUser(Request $request,$id){
  try{
    if(!$id){

      return response()->json([
        "success" => false,
        "message" => "Id is Require"
      ],400);

    }else{
      $user = Empuser::find($id);

      if(!$user){
        return response()->json([
          "success"=>false,
          "message"=>"User not found",
        ],400);
      }

      $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password,
      ]);

      return response()->json([
        "success" => true,
        "message" => "User updated successfully",
      ],200);
    }

  }catch(\Exception $e){
        return response()->json([
            "error" => $e->getMessage()
        ], 500);
  }
 }
 
  
 public function deleteUser($id){
  try{
    if(!$id){
      return response->json()([
        "success" => true,
        "message" => "Id is Require for Deleting",
      ],400);
    }else{
      $user = Empuser::find($id);
      if(!$user){
        return response->json([
          "success" => true,
          "message" => "User not found",
        ],400);
      }

      $user->delete();

      return response()->json([
          "success" => true,
          "message" => "User Deleted Successfully",
      ],200);

    }
  }catch(\Exception $e){
         return response()->json([
            "error" => $e->getMessage()
        ], 500);
  }
 }
  

 public function getAllUsers(){
  try{

    $users = Empuser::all();

    if($users->isEmpty()){
      return response()->json([
        "success" => false,
        "message" => "No users found",
      ],400);
    }

    return response()->json([
      "success" => true,
      "message" => "Users fetched successfully",
      "data" => $users
    ],200);

  }catch(\Exception $e){
        return response()->json([
            "error" => $e->getMessage()
        ], 500);
  }
}

public function createProject(Request $request){
  try{
    if(!$request->name){
      return response()->json([
        "success" => false,
        "message" => "Name is Required"
      ],400);
    }else{

      Project::create([
        "name" => $request->name,
        "assignee" => $request->assignee
      ]);

      return response()->json([
      "success" => true,
      "message" => "Project Created Successfully", 
    ],200);

    }
  }catch(\Exception $e){
            return response()->json([
            "error" => $e->getMessage()
        ], 500);
  }
}

public function getProjects(){
  try{
    
    $projects = Project::with('user:id,name')->get();

    return response()->json([
      "success" => true,
      "data" => $projects,
    ],200);

  }catch(\Exception $e){
        return response()->json([
            "error" => $e->getMessage()
        ], 500);
  }
}


}
