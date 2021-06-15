<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostLikeController extends Controller
{
    public function likeOrUnlike($id)
    {
        $post = Post::findOrFail($id);
        $user_id = 1;//dummydata
        $liked =$post->likes()->where('user_id',$user_id)->get()->count();
        if(count==0)
        {
            $post->likes()->create(['user_id'=>$user_id]);
            return response()->json(["statusCode"=>2,"message"=>"liked"]);
        }
        else
        {
            $post->likes()->where('user_id',$user_id)->delete();
            return response()->json(['statuscode'=>3,"message"=>"unliked"]);

        }
    }
    public function index($id)
    {
        $post = Post::findOrFail($id);
        $likes = $post->likes->count()->get();
        return response()->json($likes);

    }
}
