<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ResendEmailController extends Controller
{
    public function resend(Request $request){
        $request->validate([
            'email'=>'required|email'

        ]);

        $User = User::where('email', $request->email)->first();

        if(!$User){
            return response()->json([
                'message'=> 'User not found'
            ]);

        if($User->hasVerifiedEmail()){
            return response()->json([
                'message'=>'Email is already verified'
            ], 201);
        }

        $signedUrl = URL::temporarySignedRoute(
           'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $User->id,
                'hash' => sha1($User->email)

            ]);        

            $User->notify(new VerifyEmailNotification($signedUrl));

            return response()->json([
                'message'=>'Verification Email reset successful'
            ]);
        }
        }    
}
