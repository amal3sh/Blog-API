<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentReplyController extends Controller
{
    
public function index($id)
{

$comment = Comment::findOrFail($id);
$replies=$comment->replies;
return response()->json($replies);


}
public function store(Request $request, $id)
{
    $user_id =1;//dummydata
    if($request->has('content'))
    {
        $comment=Comment::findOrFail($id);
        $reply = $comment->replies()->create(['content'=>$request->content, 'user_id'=>$user_id]);
        return response()->json(["status_code"=>3,"message"=>"created"]);
    }
    else
    {
        return response()->json(["message"=>"noContentFound"]);
    }

}


}
