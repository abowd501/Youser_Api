<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use Illuminate\Http\Request;

class accountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=accounts::all();
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
        $ss=$this->validate($request,[
            'user_id'=>'required', 
            'balance'=>'required', 
            'currency'=>'required|phone', 
         
         ]);
         
         $user=accounts::Create($ss);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=accounts::find($id);
        if(is_null($data)){
            return response()->json([
                'fail'=>false,
                'message'=>'sory not find',
                
            ]);
        }
        return response()->json([
            'success'=>false,
            'message'=>'sory con not insert it',
            'data'=>$data,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input=accounts::find($id);   
        $ss=$this->validate($request,[
            'user_id'=>'required', 
            'balance'=>'required', 
            'currency'=>'required|phone', 
         
         ]);
         $cal=validator($ss);
         if ($cal->fails()){
            return response()->json([
                'fail'=>false,
                'message'=>'sory con not insert it',
                'error'=>$cal->errors(),
            ]);
         }
         
         
          /*   $request->name=$input['name'];
             $request->store_name=$input['store_name']; 
             $request->email=$input['email'];  
             $request->phone=$input['phone']; 
             $request->password=$input['password'];  
             $request->country=$input['country']; 
             $request->governorate=$input['governorate']; 
             $request->city=$input['city'];  */
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=accounts::find($id);
        $product->delete();
        return response()->json([
            'success'=>true,
            'message'=>'product deleted successfully',
            'data'=>$product
        ]);
    }
}
