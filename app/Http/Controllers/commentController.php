<?php

namespace App\Http\Controllers;

use App\Models\comment;
use Illuminate\Http\Request;

class commentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'product_id'=>'required', 
            'content'=>'required',        
         ]);

         $data=comment::Create($ss);
         return response()->json(["mess"=>$data],200);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=comment::where('product_id',$id)->with(['user'])->paginate(6);
        if(is_null($product)){
            return response()->json([
                'fail'=>false,
                'message'=>'sory not find',
                
            ]);
        }
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
