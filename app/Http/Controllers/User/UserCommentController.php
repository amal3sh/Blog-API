<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\User;

class UserCommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:api',['only'=>['index']]);
    }
    public function index()
    {
        $user = auth()->user();
        $comment = $user->comments()->with('commentable');
        return $this->showAll($comment);
        
    }

   
}
