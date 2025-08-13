<?php

namespace App\Http\Controllers;

use App\Models\requests;
use Illuminate\Http\Request;

class requestsController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=requests::with(['user'])->get();
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
        $user=auth()->user();
        $request['user_id']=$user->id;
        $ss=$this->validate($request,[
             'user_id'=>'required', 
            'image'=>'required', 
            'description'=>'required', 
         
         ]);
        $image=$request->file('image');
        if($request->hasFile('image')){
            $new_image=rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('requests-image'),$new_image);
            $ss['image']='requests-image/'.$new_image;
            $data=requests::Create($ss);
            return response()->json(["mess"=>$data],200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=requests::find($id);
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
        $input=requests::find($id);   
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
         
         
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=requests::find($id);
        $product->delete();
        return response()->json([
            'success'=>true,
            'message'=>'product deleted successfully',
            'data'=>$product
        ]);
    }
}
