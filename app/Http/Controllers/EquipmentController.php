<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
      public function createEquipment(Request $request){
        $validated = $request->validate ([
            'name' => 'required|string',
            'usage' => 'required|string',
            'model_no' => 'required|string',
            'value' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $equipment = new Equipment();
        $equipment->name = $validated['name'];
        $equipment->usage = $validated['usage'];
        $equipment->model_no = $validated['model_no'];
        $equipment->value = $validated['value'];
        $equipment->status = $validated['status'];

        try{
            $equipment->save();
            return response()->json([
                'message' => 'Equipment saved successfully'
            
            ],200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to save Equipment',
                'message'=>$exception->getMessage()
                ]);
        }
        
    } 

    public function readAllEquipments(){
        try{
            $equipments = Equipment::all();
            return response()->json([
                'message' => 'Equipment fetched'            
            ],200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to fetch Equipments',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readEquipment($id){
        try{
            $equipment=Equipment::findOrFail($id);
            return response()->json([
                'message' => 'Equipment fetched'            
            ],200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Equipments',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function updateEquipment(Request $request, $id){       
        $validated=$request->validate ([
            'name' => 'required|string',
            'usage' => 'required|string',
            'model_no' => 'required|string',
            'value' => 'required|string',
            'status' => 'required|string',
        ]);
        
        $equipment=Equipment::findOrFail($id);        
        $equipment->name = $validated['name'];       
        $equipment->usage = $validated['usage'];
        $equipment->model_no = $validated['model_no'];        
        $equipment->value = $validated['value'];
        $equipment->status = $validated['status'];
        try{
            $equipment->save();
            return response()->json([
                'message' => 'Equipment updated successfully'
            
            ],200);
        }
    
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Equipments',
                'message'=>$exception->getMessage()
            ]);
     }
}

    public function deleteEquipment($id){
        try{
            $equipment = Equipment::findOrFail($id);
            $equipment->delete();        
            return response()->json([
            'status' => 'success',
            'message' => 'Equipment deleted successfully'
        ], 200);
        }
         catch(\Exception $exception){
             return response()->json([
                'error'=>'Failed to delete Equipments',
                'message'=>$exception->getMessage()
            ]);
        }
}
}
