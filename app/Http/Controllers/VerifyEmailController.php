<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
   public function verify(Request $request, $id, $hash){
    $User = User::findOrFail($id);

    if(!hash_equals((string) $hash, sha1($User->email))){
        return response()->json([
            'message'=>'Invalid Verification Link'
        ], 403);    
        
        if ($User->hasVerifiedEmail()){
            return response()->json([
                'message'=>'Email is already verified.'
            ], 200);
        }
        
        $User->markEmailAsVerified();
        event(new Verified($User));

        $User->is_active = 1;
        $User->save();
        return response()->json([
            'message' => 'Email Verified Succesfully!'

   ]);
   }
}
}
