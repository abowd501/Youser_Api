<?php

namespace App\Http\Controllers;

use App\Models\followers;
use App\Models\User;
use Illuminate\Http\Request;

class followersController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=followers::with('user')->get();
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
        $user=auth()->user()->id;
        $request['follower_id']=$user;
        $ss=$this->validate($request,[
            'followed_id'=>'required',
            'follower_id'=>'required', 
         ]);

         /*$data=followers::Create($ss);
         return response()->json(["mess"=>$data],200);*/
  
         if(!$request->followed_id||$user===$request->followed_id){
             return response()->json(["message"=>"404 not Found"],500);  
         }
 
         $unlike=followers::where('follower_id',$user)->where('followed_id',$request->followed_id)->delete();
         if ($unlike) {
             return response()->json(["message"=>"unfollowing"],200);
         }
          $liked=followers::Create($ss);
          if ($liked) {
            return response()->json(["message"=>"following"],200);
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
        $user=auth()->user()->id;

  
         if(!$id){
             return response()->json(["message"=>"404 not Found"],500);  
         }
 
         if ($id==1) {
            $data=User::find($user)->followers()->paginate(4);
            $like=followers::where('followed_id',$user)->pluck('follower_id')->toArray();
            foreach ($data as $pro ) {
                $pro->isfollowed=in_array($pro->id,$like);
            }
             return response()->json($data,200);
         }
          if ($id==2) {
            $data=User::find($user)->following()->paginate(4);
            $like=followers::where('follower_id',$user)->pluck('followed_id')->toArray();
            foreach ($data as $pro ) {
                $pro->isfollowed=in_array($pro->id,$like);
            }
            return response()->json($data,200);
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
        $product=followers::find($id);
        $product->delete();
        return response()->json([
            'success'=>true,
            'message'=>'product deleted successfully',
            'data'=>$product
        ]);
    }
}
