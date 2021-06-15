<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentLikeController extends Controller
{
    public function index($id)
    {
        $comment = Comment::findOrFail($id);
        $likes = $comment->likes()->count()->get();
        return response()->json($likes);

    }
    public function likeOrUnlike($id)
    {
        $comment = Comment::findOrFail($id);
        $user_id = 1;//dummydata
        $liked = $comment->likes()->where('user_id',$user_id)->get()->count();
        if(count==0)
        {
            $comment->likes()->create(['user_id'=>$user_id]);
            return response()->json(["statusCode"=>2,"message"=>"liked"]);
        }
        else
        {
            $comment->likes()->where('user_id',$user_id)->delete();
            return response()->json(['statuscode'=>3,"message"=>"unliked"]);

        }
    }




}
