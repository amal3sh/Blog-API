<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Post;

class PostLikeController extends ApiController
{
    public function likeOrUnlike($id)
    {
        $post = Post::findOrFail($id);
        $user_id = 3;//dummydata
        $liked =$post->likes()->where('user_id',$user_id)->get()->count();
        
        if($liked)
        {
            $post->likes()->where('user_id',$user_id)->delete();
            return $this->successResponser("Unliked ",200);
        }
        else
        {
            $post->likes()->create(['user_id'=>$user_id]);
            return $this->successResponser("Liked ",200);

        }
    }
    public function index($id)
    {
        $post = Post::findOrFail($id);
        $likes = $post->likes->count()->get();
        return $this->showAll($likes);

    }
}
