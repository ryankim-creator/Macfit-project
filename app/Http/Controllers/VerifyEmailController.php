<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
   public function verify(Request $request, $id, $hash){
    $User = User::findOrfail('id', $id);

    if(!hash_equals((string) $hash, sha1($User->email))){
        return response()->json([
            'message'=>'Invalid Verification Link'
        ], 403);    
        
        if ($user->hasVerifiedEmail()){
            return response()->json([
                'message'=>'Email is already verified.'
            ], 200);
        }
        
        $User->markEmailAskVerified();
        event(new Verified($User));

        $User->is_active = 1;
        $User->save();
        return response()->json('Email Verified Succesfully!');

   }
}
}
