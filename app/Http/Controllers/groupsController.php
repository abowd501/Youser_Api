<?php

namespace App\Http\Controllers;

use App\Models\groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class groupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=groups::all();
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
        $this->validate($request,[
            'name_group'=>'required',          
         ]);
        
        $user=groups::Create([
             'name_group'=>$request->name_group, 
         ]);

         return response()->json([
            'fail'=>false,
            'message'=>'isert data successfully',
            'data'=>$user,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=groups::find($id);
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
        $input=groups::find($id);   
        $date=$request->validate([
            'name_group'=>'required', 
         
         ]);

       
         $input->update($date);
         return response()->json([
            'success'=>true,
            'message'=>'product update successfully',
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
        $product=groups::find($id);
        $product->delete();
        return response()->json([
            'success'=>true,
            'message'=>'product deleted successfully',
            'data'=>$product
        ]);
    }

}
