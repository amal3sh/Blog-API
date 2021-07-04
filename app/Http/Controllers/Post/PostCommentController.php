<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Post;

class PostCommentController extends ApiController
{
    public function __construct()
   {
       $this->middleware('auth:api',['only'=>['store']]);
   }
    public function index($id)
    {
       
        $post = Post::findOrFail($id);
        $comments = $post->comments;
        return $this->showAll($comments);

    }
    public function store(Request $request,$id)
    {   $post = Post::findOrFail($id);
        $user_id=auth()->user()->id;
        if($request->has('content'))
        {

            $comment = $post->comments()->create(['content'=>$request->content,'user_id'=>$user_id]);
            return $this->showOne($comment);


        }
       
           return $this->errorResponse("Empty Comment",406);
        
    }


}
