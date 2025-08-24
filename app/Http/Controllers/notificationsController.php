<?php

namespace App\Http\Controllers;

use App\Models\notification;
use Berkayk\OneSignal\OneSignalClient;
use Berkayk\OneSignal\OneSignalFacade;
use Illuminate\Http\Request;
use Berkayk\OneSignal\OneSignalFacade as OneSignal;
use Illuminate\Notifications\Notification as NotificationsNotification;

class notificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                $product=notification::all();
        return response()->json([
            'success'=>true,
            'message'=>'All Progucts',
            'data'=>$product,
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                $data=$this->validate($request,[
                    'title'=>'required', 
                    'description'=>'required', 
                    'imageUrl'=>'required',        
                 ]);


        OneSignal::sendNotificationToAll(
            $request->title,
            $request->imageUrl,
            $data
        );

        $note=notification::Create($data);
        return response()->json([
            'message' => 'Notification sent to all users',
        ], 200);
 

        
     

         
    }


    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=notification::find($id);
        if($product->user_id==auth()->user()->id){
        
        $product->delete();
        return response()->json([
            'success'=>true,
            'message'=>'تم الحذف بنجاح',
            'data'=>$product
        ]);
    }
    }
}
