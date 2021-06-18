<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserPutRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show($id)
    {
      if(User::where('id',$id)->exists())
      {
          $user = User::find($id);
        return $this->showOne($user); 

      }
     
      else
      {
          return $this->errorResponse("Not found",404);
      }
   
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
        $user = User::findOrFail($id);
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
    public function destroy($id)
    {
        if(User::where("id",$id)->exists())
        {
            $user = User::find($id);
            $user->delete();
            return $this->showOne($user,200);
            
        

        }
        else
        {
            return $this->errorResponse("Not found",404);

        }
    }
}
