<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ResendEmailController extends Controller
{
    public function resend(Request $request){
        $request->validate([
            'email'=>'required|email'

        ]);

        $User = User::where('email', $request->email->first());

        if(!$User){
            return response()->json([
                'message'=> 'User not found'
            ])

        if($User->hasVerifiedEmail()){
            return response()->json([
                'message'=>'Email is already verified'
            ], 201)
        }

        $signedUrl = Url::temporarySignedRoute{
            'verification.verify',
            now()->addMinutes(60),
            [
                'id'=>$User->id,
                'hash'=>shal($User->email)

            ]
            );

            $User->notifynew VerifyEmailNotification($signedUrl);

            return response()->json[
                'message'=>'Verification Email reset successful'
            ]
        }
        }
    }
}
