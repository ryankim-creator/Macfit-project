<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
   public function createBundle(Request $request){
        $validated = $request->validate ([
            'name' => 'required|string',
            'start_time' => 'required',
            'duration' => 'required',
            'description' => 'string|max:1000',
            'category_id' => 'integer|exists:category,id'
        ]);

        $bundle = new Bundle();
        $bundle->name = $validated['name'];
        $bundle->start_time= $validated['start_time'];
        $bundle->duration = $validated['duration'];
        $bundle->description = $validated['description'];
        $bundle->category_id = $validated['category_id'];


        try{
            $bundle->save();
            return response()->json($bundle);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to save Bundle',
                'message'=>$exception->getMessage()
                ]);
        }
        
    } 

    public function readAllBundles(){
        try{
            $bundles = Bundle::all();
            // $bundle = Bundle:join('categories','bundle.category_id,'=','categories.id')
            //                 ->select('bundles.*, 'categories.name as category_name')
            //                 ->get()
            //                 ->where('bundles.id',$id)
            //                 ->first();
            return response()->json($bundles);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to fetch Bundles',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readBundle($id){
        try{
            $bundle=Bundle::findOrFail($id);
            // $bundle = Bundle:join('categories','bundle.category_id,'=','categories.id')
            //                 ->select('bundles.*, 'categories.name as category_name')                        
            //                 ->where('bundles.id',$id)
            //                 ->first();
            return response()->json($bundle);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Bundles',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function updateBundle(Request $request, $id){       
        $validate=$request->validate ([
            'name' => 'required|string',
            'start_time' => 'required',
            'duration' => 'required',
            'description' => 'string|max:1000',
            'category_id' => 'integer|exists:categories,id'
        ]);
        try{
        $bundle = Bundle::findOrFail($id);       
        $bundle->name = $validate['name'];
        $bundle->start_time= $validate['start_time'];
        $bundle->duration = $validate['duration'];
        $bundle->description = $validate['description'];
        $bundle->category_id = $validate['category_id'];
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Bundles',
                'message'=>$exception->getMessage()
            ]);
     }
}

    public function deleteBundle($id){
        try{
            $bundle = Bundle::findOrFail($id);
            $bundle->delete();        
            return response()->json([
            'status' => 'success',
            'message' => 'Bundle deleted successfully'
        ], 200);
        }
         catch(\Exception $exception){
             return response()->json([
                'error'=>'Failed to delete Bundles',
                'message'=>$exception->getMessage()
            ]);
        }
}   
}
