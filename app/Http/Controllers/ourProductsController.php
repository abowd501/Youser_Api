<?php

namespace App\Http\Controllers;

use App\Models\ourImages;
use App\Models\ourProducts;
use Illuminate\Http\Request;

class ourProductsController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
     public function index(Request $request)
     {
         $query=ourProducts::query();
         $user=auth()->user()->id;
         $product=$query->with(['image'])->paginate(3);
 

 
 
         return response()->json($product,
         200);
     }
     /**
      * search for product 
      * 
      */
     public function search(Request $request)
     {
         $query=ourProducts::query();
         //$user=auth()->user()->id;
         $value=$request->input('value');
         if($request->filled('value')){
             $query->where(function ($q) use($value){
                 $q->where('name','LIKE',"%{$value}%")->orWhere('group','LIKE',"%{$value}%");
             });
         }

 
         //$product=$query->paginate(2);
         $product=$query->with(['image'])->paginate(3);
 

 
 
 
         return response()->json($product,
         200);
     
 
 
         
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
        //$request['admin_id']=1;
         $ss=$this->validate($request,[
             'group_id'=>'required', 
             //'admin_id'=>'requird',
             'name'=>'required', 
             'show'=>'required',
             'currency'=>'required', 
             'price'=>'required', 
             //'image'=>'required', 
             'description'=>'required', 
          
          ]);
          $ss['admin_id']=1;
 
         $data=ourProducts::Create($ss);
         // save image in database and file
         
         $images=$request->file('image');
         if($request->hasFile('image')){
             foreach ($images as $key => $image) {
             //$image=$request->file('image');
             
                 $new_image=rand().'.'.$image->getClientOriginalExtension();
                 $image->move(public_path('ourproduct-image'),$new_image);
                 $dataimage=ourImages::Create([ 'product_id'=>$data->id,'image'=>$new_image]);
                 
             } 
         }
         /*
         $image=$request->file('image');
         if($request->hasFile('image')){
             $new_image=rand().'.'.$image->getClientOriginalExtension();
             $image->move(public_path('product-image'),$new_image);
             $dataimage=Images::Create([ 'product_id'=>$data->id,'image'=>$new_image]);
             
         }*/
         return response()->json(["message"=>"successully","dataImage"=>count($request->image)],200);
     }
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
         $query=ourProducts::query();
         $user=auth()->user()->id;
         $product=$query->with(['image','user'])->find($id);
 
        // $like=likes::where('user_id',$user)->pluck('product_id')->toArray();
         //    $product['liked']=in_array($product->id,$like);
         
 
 
         return response()->json(["data"=>$product],
         200);
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
         $input=ourProducts::find($id);   
         $data=$this->validate($request,[
             'group_id'=>'required', 
             'name'=>'required', 
             'currency'=>'required', 
             'price'=>'required', 
             'country'=>'required', 
             'description'=>'required',
          
          ]);
 
          $input->update($data);
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
         $product=ourProducts::find($id);
         $product->delete();
         return response()->json([
             'success'=>true,
             'message'=>'product deleted successfully',
             'data'=>$product
         ]);
     }
}
