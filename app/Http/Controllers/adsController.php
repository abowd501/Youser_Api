<?php

namespace App\Http\Controllers;

use App\Models\ads;
use Illuminate\Http\Request;

class adsController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=ads::all();
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
        //return response()->json(["mess1"=>$request->file('image')],200);
        $image=$request->file('image');
        if($request->hasFile('image')){
            $new_image=rand().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('ads-image'),$new_image);
            $data=ads::Create(['image'=>'ads-image/'.$new_image]);
            return response()->json(["mess"=>$new_image],200);
        }

         #$data=ads::Create($request);
         return response()->json(["mess1"=>$image],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=ads::find($id);
        if(is_null($product)){
            return response()->json([
                'fail'=>false,
                'message'=>'sory not find',
                
            ]);
        }
        return response()->json([
            'success'=>false,
            'message'=>'sory con not insert it',
            'data'=>$product,
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
        $input=ads::find($id);   
        
         $image=$request->file('image');
         if($request->hasFile('image')){
             $new_image=rand().'.'.$image->getClientOriginalExtension();
             $image->move(public_path('ads-image'),$new_image);
             $data=$input->update(['image'=>$new_image]);
             return response()->json(['message'=>'product update successfully',"mess"=>$new_image],200);
         }

         return response()->json([
            'success'=>true,
            'message'=>'product e can ont updat',
            'data'=>$input
            ],200);
      
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=ads::find($id);
        $product->delete();
        return response()->json([
            'success'=>true,
            'message'=>'product deleted successfully',
            'data'=>$product
        ]);
    }
}
