<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddUserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class addUserController extends Controller
{
    public function addUser(Request $request){
        try{

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:campaign_user,email',
                'status' => 'required',
                'password' => 'required|min:8'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "success" => false,
                    "message" => $validator->errors()
                ], 400);
            }

            AddUserModel::create([
                'name' => $request->name,
                'email' => $request->email,
                'status' => $request->status,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                "success" => true,
                "message" => "User created successfully with encrypted password",
            ], 200);

        }catch (\Exception $e) {

            return response()->json([
                "error" => $e->getMessage()
            ], 500);

        }
    }

    public function getUsers(){
        try{

        $users = AddUserModel::all();

        return response()->json([
            "success" => true,
            "data" => $users
        ], 200);

        }catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

        }
    }

    public function updateUser(Request $request, $id){
        try{

        $user = AddUserModel::find($id);

        if(!$user){
            return response()->json([
                "success" => false,
                "message" => "User not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:campaign_user,email,' . $id,
            'status' => 'required',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 400);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            "success" => true,
            "message" => "User updated successfully"
        ], 200);

        }catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

        }
    }

    public function deleteUser($id){
        try{

        $user = AddUserModel::find($id);

        if(!$user){
            return response()->json([
                "success" => false,
                "message" => "User not found"
            ], 404);
        }

        $user->delete();

        return response()->json([
            "success" => true,
            "message" => "User deleted successfully"
        ], 200);

        }catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

        }
    }

    public function loginUser(Request $request){
        try{

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->errors()
            ], 400);
        }

        // Find user by email
        $user = AddUserModel::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                "success" => false,
                "message" => "Email not found"
            ], 404);
        }

        // Check password
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                "success" => false,
                "message" => "Invalid password"
            ], 401);
        }

        // Optional: check user status (if 0 = inactive, 1 = active)
        // if($user->status == 0){
        //     return response()->json([
        //         "success" => false,
        //         "message" => "User is inactive"
        //     ], 403);
        // }

        return response()->json([
            "success" => true,
            "message" => "Login successful",
            "data" => $user
        ], 200);

        }catch (\Exception $e) {

        return response()->json([
            "error" => $e->getMessage()
        ], 500);

    }
    }

}