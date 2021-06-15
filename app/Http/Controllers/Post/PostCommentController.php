<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostCommentController extends Controller
{
    
    public function index($id)
    {
       
        $post = Post::findOrFail($id);
        $comments = $post->comments;
        return response()->json($comments);

    }
    public function store(Request $request,$id)
    {   $post = Post::findOrFail($id);
        $user_id=1;//dummy_data
        if($request->has('content'))
        {

            $comment = $post->comments->create(['content'=>$request->content,'user_id'=>$user_id]);
            return response()->json($comment);


        }
        else
        {
            return response()->json(['code'=>404,"messsage"=>"notFound"]);
        }
    }


}
