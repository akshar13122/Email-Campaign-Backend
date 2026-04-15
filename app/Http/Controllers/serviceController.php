<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\serviceModel;

class serviceController extends Controller{
    public function postService(Request $request){
        try{
            if(!$request->service){
                return response()->json([
                    "success"=>false,
                    "message"=>"service is erquire",
                ],400);
            }else{
                serviceModel::create([
                    'service'=>$request->service,
                ]);

                return response()->json([
                      "success"=>true,
                    "message"=>"service created successfully",
                ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function getService(Request $request){
        try{
             $service = serviceModel::all();
             if($service->isEmpty()){

                return response()->json([
                      "success"=>false,
                    "message"=>"No services found",
                ],400);
             }else{
                return response()->json([
                    "success"=>true,
                    "message"=>"service fetched successfully",
                    "data"=>$service,
                ],200);
             }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }

    public function updateService(Request $request,$id){
        try{
            if(!$id){
                  return response()->json([
                    "success"=>false,
                    "message"=>"id is needed",
                ],400);
            }else{
                $service = serviceModel::find($id);
                if(!$service){
                    return response()->json([
                    "success"=>false,
                    "message"=>"service is not found",
                ],400);
                }

                $service->update([
                    "service"=>$request->service,
                ]);

                return response()->json([
                "success"=>true,
                "message"=>"service updated successfully",
                "data"=>$service,
                ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }


    public function deleteService($id){
        try{
            $service = serviceModel::find($id);
            if(!$service){
                 return response()->json([
                    "success"=>false,
                    "message"=>"no Service found",
                    ],400);
            }else{
                $service->delete();
                 return response()->json([
          "success" => true,
          "message" => "Service Deleted Successfully",
          ],200);
            }
        }catch(\Exception $e){
             return response()->json([
            "error" => $e->getMessage()
        ], 500);
        }
    }
}



