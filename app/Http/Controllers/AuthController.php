<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
   public function register(Request $request){
    $validated = $request->validate([
        'name' => 'required|string|max:40',
        'email' => 'required|string|email|unique:users',
        'password' => 'required|string|min:4|max:15|confirmed',
        'user_image' => 'nullable|mimes:jpeg,png,jpg',        
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

            $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id'=>$user->id,
                'hash'=>sha1($user->email)
            ]
        );

        $user->notify(new VerifyEmailNotification($signedUrl));

        return response()->json([
            'message'=>'Verification Email resent successfully.'
        ], 200);

        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Registration Failed',
                'message'=>$exception->getMessage()
            ], 500);
        }
    }


  public function login(Request $request){
     $validated = $request->validate([        
        'email' => 'required|email',
        'password' => 'required|string|min:4|max:15'
    ]);

    
    $user = User::where('email', $validated['email'])->first();

    if(!$user || !Hash::check($validated['password'], $user->password)){
    throw ValidationException::withMessages([
            'email' => ['Invalid Credentials'],
    ], 400);
    }
        
    if(!$user->is_active){
        return response()->json([
            'message'=>'Your account is not active.Please verify your account.'
        ], 400);
    }
    

    $token = $user->createToken('auth-token')->plainTextToken;
    return response()->json([        
        'Message' => 'Login Successful!',
        'token' => $token,
        'user' => $user,       
    ], 200);
   }   

  public function logout(Request $request){
    $request->user()->currentAccessToken()->delete();
    return response()->json([
        'message' => 'Logout Successful.'
        ]);
  }

//   public function userInfo(){
//     return response()->json(auth()->user());
//   }
}