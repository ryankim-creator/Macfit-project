<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
         public function createSubscription(Request $request){
        $validated = $request->validate ([
         
            'bundle_id' => 'required|string|exists:bundles,id',           
        ]);

        // $userId = auth()->user()->id;

        $subscription = new Subscription();
        $subscription->user_id = $validated['user_id'];
        $subscription->bundle_id = $validated['bundle_id'];       

        try{
            $subscription->save();
            return response()->json([
                'message' => 'Subscription saved successfully'
            
            ],200);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to save Subscription',
                'message'=>$exception->getMessage()
                ]);
        }
        
    } 

    public function readAllSubscriptions(){
        try{
            $subscriptions = Subscription::all();
            // $subscriptions = Subscription::join('users,subscription,user_id''=''users_id')
            // ->join('bundles')
            return response()->json($subscriptions);
        }
        catch(\Exception $exception){
            return response()->json([
                'error' => 'Failed to fetch Subscriptions',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function readSubscription($id){
        try{
            $subscription=Subscription::findOrFail($id);
            return response()->json($subscription);
        }
        catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Subscriptions',
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function updateSubscription(Request $request, $id){       
        $validated=$request->validate ([
          'user_id' => 'required|integer|exists:users,id',
          'bundle_id' => 'required|string|exists:bundles,id', 
        ]);
      
        $subscription=Subscription::findOrFail($id);        
        $subscription->user_id = $validated['user_id'];       
        $subscription->bundle_id = $validated['bundle_id'];     
     try{
            $subscription->save();
            return response()->json([
                'message'=>'Bundle Updated Successfully.'
            ], 200);
        }
     catch(\Exception $exception){
            return response()->json([
                'error'=>'Failed to fetch Subscriptions',
                'message'=>$exception->getMessage()
            ]);
     }
}

    public function deleteSubscription($id){
        try{
            $subscription = Subscription::findOrFail($id);
            $subscription->delete();        
            return response()->json([
            'status' => 'success',
            'message' => 'Subscription deleted successfully'
        ], 200);
        }
         catch(\Exception $exception){
             return response()->json([
                'error'=>'Failed to delete Subscriptions',
                'message'=>$exception->getMessage()
            ]);
        }
}

// public function getUserChargers(){
//     $userId = auth 
// }
}
