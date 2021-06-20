<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentLikeController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api',['only'=>['likeOrUnlike']]);
    }


    public function index($id)
    {
        $comment = Comment::findOrFail($id);
        $likes = $comment->likes()->count()->get();
        return showAll($likes);

    }
    public function likeOrUnlike($id)
    {
        $comment = Comment::findOrFail($id);
        $user_id = auth()->user()->id;
        $liked = $comment->likes()->where('user_id',$user_id)->get()->count();
        if($liked)
        {
            $comment->likes()->where('user_id',$user_id)->delete();
           return $this->successResponse("Unliked",200);
            
        }
        else
        {
            $comment->likes()->create(['user_id'=>$user_id]);
            return $this->successResponse("Liked",200);

        }
    }




}
