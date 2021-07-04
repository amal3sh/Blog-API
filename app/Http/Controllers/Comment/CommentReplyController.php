<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentReplyController extends ApiController
{
public function  __construct()
{
    $this->middleware('api:auth',['only'=>['store']]);
}

public function index($id)
{

$comment = Comment::findOrFail($id);
$replies=$comment->replies;
return $this->showAll($replies);


}
public function store(Request $request, $id)
{
    $user_id =auth()->user()->id;
    if($request->has('content'))
    {
        $comment=Comment::findOrFail($id);
        $reply = $comment->replies()->create(['content'=>$request->content, 'user_id'=>$user_id]);
        return $this->showOne($reply);
    }
    else
    {
        return $this->errorResponse("Comment body is blank",204);
    }

}


}
