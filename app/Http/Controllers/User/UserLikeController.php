<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)

    {
        $user= User::findOrFail($id);
        $likes = $user->likes()->with('likable')->get();
        return response()->json($likes);


    }

   
}
