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
            return response()->json($role);
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
        $validate=$request->validate ([
            'name'=>'required|string|unique:roles,name',
            'description'=>'nullable|string|max:1000',
        ]);
        try{
        $existingCategory = Category::findOrFail($id);
        $existingCategory = new Category();
        $existingCategory->name = $validate['name'];
        $existingCategory-> description->name = $validate['description'];
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
