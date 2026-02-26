<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
   public function register(Request $request){
    $validated = $request->validate([
        'name' => 'required|string|max:40',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:4|max:15|confirmed',
        'user_image' => 'nullable|string|max:225|mimes:jpeg,png,jpg',        
        'role_id' => 'required|integer|exists:roles,id',
    ]);

    if($request->has('role_id')){
       $role_id = $request->role_id;     
    } else{
        $role = Role::where('name','User')->first();
        $role_id =$role->id;
    }   

    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->role_id = $validated['role_id'];  
    $user->password = Hash::make($validated['password']);

    if($request->hasFile('user_image')){
       $filename = $request->file('user_image')->store('users','public');     
    } else{
        $filename = null;
    }
     $user->user_image = $filename;

    try{
        $user->save(); 
         return response()->json([
                'message' => 'User registered successfully!',
                'user' => $user
            ], 200);
    }
    catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to register user',
                'message'=>$exception->getMessage()
            ], 500);
    } 
   }   

  public function login(Request $request){
     $validated = $request->validate([        
        'email' => 'required|email',
        'password' => 'required|string|min:4|max:15'
    ]);

    try{
    $user = User::where('email', $validated['email'])->first();

    if(!$user || !Hash::check($validated['password'], $user->password)){
    throw ValidationException::withMessages([
            'email' => ['Invalid Credentials'],
    ]);
    }
        
    if(!$user->is_active){
        return response()->json([
            'message'=>'Your account is not active.Please verify your account.'
        ]);
    }
    

    $token = $user->createToken('auth-token')->plainTextToken;
    return response()->json([        
        'Message' => 'Login Successful!',
        'token' => $token,
        'user' => $user,
        'abilities' => $user->abilities(),
    ], 200);
   }
    catch (\Exception $exception){
        return response()->json([
            'Error' => 'Invalid Credentials.'
        ], 500);
    }
  }  
  

  public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json([
        'message' => 'Logout Successful.'
        ]);
  }
}