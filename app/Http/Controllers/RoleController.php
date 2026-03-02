<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{

    public function _construct(){
        $this->authorizeResource(Role::class);
    }

    // CRUD FUNCTIONS
    // Create
    public function createRole(Request $request){
        $validated = $request->validate ([
            'name' => 'required|string|unique:roles,name',
            'description' => 'nullable|string|max:1000',
        ]);

        $role = new Role();
        $role->name = $validated['name'];
        $role->description = $validated['description'];

        try{
            $role->save();
            return response()->json([
                'message' => 'Role saved successfully'
            
            ],200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to save Role',
                'message'=>$exception->getMessage()
                ]);
        }
        
    } 

    public function readAllRoles(){  

        $this->authorize(Role::class, 'viewAny');

        try{
            $roles = Role::all();
            return response()->json($roles);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to fetch Roles',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readRole($id){
        try{
            $role=Role::findOrFail($id);
            return response()->json($role);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Roles',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function updateRole(Request $request, $id){       
        $validated=$request->validate ([
            'name'=>'required|string|unique:roles,name',
            'description'=>'nullable|string|max:1000',
        ]);
        
        $role =Role::findOrFail($id);       
        $role->name = $validated['name'];
        $role-> description->name = $validated['description'];
     try{
            $role->save();
            return response()->json([
                'message'=>'Bundle Updated Successfully.'
            ], 200);
        }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to update Role',
                'message'=>$exception->getMessage()
            ]);
     }
}

    public function deleteRole($id){
        try{
            $role = Role::findOrFail($id);
            $role->delete();        
            return response()->json([
            'status' => 'success',
            'message' => 'Role deleted successfully'
        ], 200);
        }
         catch(\Exception $exception){
             return response()->json([
                'error'=>'Failed to delete Roles',
                'message'=>$exception->getMessage()
            ]);
        }
}
}