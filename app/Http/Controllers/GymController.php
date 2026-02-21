<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;

class GymController extends Controller
{
     public function createGym(Request $request){
        $validated = $request->validate ([
            'name' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'description' => 'string|max:1000',
        ]);

        $gym = new Gym();
        $gym->name = $validated['name'];
        $gym->longitude = $validated['longitude'];
        $gym->latitude = $validated['latitude'];
        $gym->description = $validated['description'];

        try{
            $gym->save();
            return response()->json($gym);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to save Gym',
                'message'=>$exception->getMessage()
                ]);
        }
        
    } 

    public function readAllGyms(){
        try{
            $gyms = Gym::all();
            return response()->json($gyms);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to fetch Gyms',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readGym($id){
        try{
            $gym=Gym::findOrFail($id);
            return response()->json($gym);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Gyms',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function updateGym(Request $request, $id){       
        $validate=$request->validate ([
            'name' => 'required|string',
            'longitude' => 'required|string',
            'latitude' => 'required|string',
            'description' => 'string|max:1000',
        ]);
        try{
        $gym=Gym::findOrFail($id);        
        $gym->name = $validate['name'];       
        $gym->longitude = $validate['longitude'];
        $gym->latitude = $validate['latitude'];        
        $gym-> description->name = $validate['description'];
    }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Gyms',
                'message'=>$exception->getMessage()
            ]);
     }
}

    public function deleteGym($id){
        try{
            $gym = Gym::findOrFail($id);
            $gym->delete();        
            return response()->json([
            'status' => 'success',
            'message' => 'Gym deleted successfully'
        ], 200);
        }
         catch(\Exception $exception){
             return response()->json([
                'error'=>'Failed to delete Gyms',
                'message'=>$exception->getMessage()
            ]);
        }
}
}
