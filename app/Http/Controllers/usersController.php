<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class usersController extends Controller
{
    /**
     * Create a new User .
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request){
        $request['password']=Hash::make($request->password);
        $data=$this->validate($request,[
           'name'=>'required', 
           'store_name'=>'required', 
           'email'=>'required|email|', 
           'phone'=>'required', 
           'password'=>'required|min:8', 
           'country'=>'required', 
           'governorate'=>'required', 
           'city'=>'required', 
        
        ]);
        //$data['password']=Hash::make($request->password);
        $user=User::Create($data);
        $token=$user->createToken('Ali772240564')->accessToken;
        return response()->json(['token'=>$token,'message'=>$user->notifications()],200);
    }
    public function login(Request $request){
        $data=[
           'email'=>$request->email,  
           'password'=>$request->password, 
        ];
        if(auth()->attempt($data)){
         $user=Auth::user(); 
         $token=$request->user()->createToken('*#Ali772240564#*')->accessToken;
         return response()->json(['message'=>'Seccusfully conacted ','token'=>$token,'username'=>$user->name],200);
        }else{
          return response()->json(['message'=>'Faild conacted ','token'=>$data
        ],401);
        }
        
        
    }

    
    public function userInfo()
    {
        $user=auth()->user()->id;
        $d=User::where('id',$user)->withCount(['products'])->get();//->withCount(['followers','following','products']);//->get()->where('id',$user);
        return response()->json(['data'=>$d],200);
    }

    public function user()
    {
        $user=auth()->user()->id;
        $d=User::withCount(['products'])->get();//->withCount(['followers','following','products']);//->get()->where('id',$user);
        return response()->json(['data'=>$d],200);
    }
    

    public function update(Request $request)
    {
        $user=User::find(auth()->user()->id);
        
        $data=$this->validate($request,[
           'name'=>'required', 
           'store_name'=>'required', 
           'image'=>'sometimes',
           'email'=> [
                    'sometimes',
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore(auth()->user()->id)
                ], 
           'phone'=> [
                    'sometimes',
                    'required',
                    'string',
                    
                    'max:255',
                    Rule::unique('users')->ignore(auth()->user()->id)
                ], 
           'country'=>'required', 
           'governorate'=>'required', 
           'city'=>'required', 
        
        ]);
        //if($data['phone']===$user->){}
        $image=$request->file('image');
        
            //$image=$request->file('image');
            echo 'goooooo';
                $new_image=rand().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('users-images'),$new_image);
                $data['image']='users-images/'.$new_image;
                
 
       

        $user->update($data);
        return response()->json(['message'=>'تم العملية بنجاح','data'=>$data],200);
        echo $data['image'];
    }


    public function Logout(Request $request)
    {
        $user=Auth::user();
        $token=$user->token;
        $token->revoke();
    }

     

}
