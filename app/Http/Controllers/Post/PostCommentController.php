<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Post;

class PostCommentController extends ApiController
{
    
    public function index($id)
    {
       
        $post = Post::findOrFail($id);
        $comments = $post->comments;
        return $this->showAll($comments);

    }
    public function store(Request $request,$id)
    {   $post = Post::findOrFail($id);
        $user_id=3;//dummy_data
        if($request->has('content'))
        {

            $comment = $post->comments()->create(['content'=>$request->content,'user_id'=>$user_id]);
            return $this->showOne($comment);


        }
        else
        {
            return $this->errorResponse("Comment doesn't exist",404);
        }
    }


}
