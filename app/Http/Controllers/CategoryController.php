<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
     public function createCategory(Request $request){
        $validated = $request->validate ([
            'name' => 'required|string|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        $role = new Category();
        $role->name = $validated['name'];
        $role->description = $validated['description'];

        try{
            $role->save();
            return response()->json([
                'message' => 'Category saved successfully'
            
            ],200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to save Category',
                'message'=>$exception->getMessage()
                ]);
        }
        
    } 

    public function readAllCategories(){
        try{
            $roles = Category::all();
            return response()->json($roles);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to fetch Categories',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readCategories($id){
        try{
            $role=Category::findOrFail($id);
            return response()->json($role);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Categories',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function updateCategory(Request $request, $id){       
        $validated=$request->validate ([
            'name'=>'required|string|unique:roles,name',
            'description'=>'nullable|string|max:1000',
        ]);
       
        $Category = Category::findOrFail($id);       
        $Category->name = $validated['name'];
        $Category-> description->name = $validated['description'];
  
        try{
            $Category->save();
            return response()->json([
                'message'=>'Bundle Updated Successfully.'
            ], 200);
        }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Categories',
                'message'=>$exception->getMessage()
            ]);
     }
}

    public function deleteCategory($id){
        try{
            $role = Category::findOrFail($id);
            $role->delete();        
            return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ], 200);
        }
         catch(\Exception $exception){
             return response()->json([
                'error'=>'Failed to delete Categories',
                'message'=>$exception->getMessage()
            ]);
        }
}
}
