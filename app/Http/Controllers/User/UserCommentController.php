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
    public function index($id)
    {
        $user = User::findOrFail($id);
        $comment = $user->comments()->with('commentable');
         return $this->showAll($comment);
        
    }

   
}
