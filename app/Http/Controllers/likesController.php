<?php

namespace App\Http\Controllers;

use App\Models\likes;
use App\Models\Products;
use Illuminate\Http\Request;

class likesController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=auth()->user()->id;
        $query=Products::query();
        $query->WhereHas('likes',function ($q) use($user){
            $q->where('user_id','=',$user);});
    
        /* $query ->with(['group','image','likes' =>function($query){
                $query->user_id= auth()->user()->id;
*/            
            $product=$query->with(['image','user'])->paginate(10);
        return response()->json($product,200);
    }

    /**
     * Make like nad disliked for products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=auth()->user()->id;
  
        if(!$id){
            return response()->json(["message"=>"404 not Found"],500);  
        }

        $unlike=Likes::where('user_id',$user)->where('product_id',$id)->delete();
        if ($unlike) {
            return response()->json(["message"=>"unliked"],200);
        }
         $liked=likes::Create([
            'user_id'=>$user,
            'product_id'=>$id
         ]);
         if ($liked) {
           return response()->json(["message"=>"liked"],200);
         }
         
    }







}
