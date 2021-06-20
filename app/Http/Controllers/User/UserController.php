<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserPutRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{
    
    
    public function __construct()
    {
        $this->middleware('auth:api',['only'=>['update','destroy','logout','show','reload']]);
    }
    
    
    
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data=$request->except(['image']);
        $data['password']=Hash::make($request->password);
        $user = User::create($data);

        if($request->hasFile('image'))
        {
            $image = $request->file('image')->store('public/images');

            $user->image()->create(['url'=>$image]);
        }
        return $this->showOne($user,201);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
      
          $user = auth()->user();
          return $this->showOne($user,200); 

    }



    public function login(LoginRequest $request)
      {
         
        $credentials = $request->only(['email','password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return response()->json(compact('token'));

      }
      
      
      public function logout()
      {

        auth()->logout();
        return $this->successResponse("Succesfully Signed out",200);
    

      }

      public function reload()
      {
         $token = JWTAuth::getToken();
         return response()->json([JWTAuth::refresh($token)]);
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
        $user = auth()->user();
        $user->name = !empty($request->name)?$request->name:$user->name;
        $user->email = !empty($request->email)?$request->email:$user->email;
        $user->password = !empty($request->password)?$request->password:Hash::make($user->password);
        $user->update();
        
        if($request->hasFile('image'))
        {
            $image = $request->file('image')->store('public/images');            
            
            $user->image()->updateOrCreate(['url'=>$image]);
        }
        return $this->showOne($user,200);
       
      
        
        //doubtsregarding_validation

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        
            $user = auth()->user();
             $user->delete();
            return $this->showOne($user,200);
            
               
    }

   
}
