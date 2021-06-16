<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function update(Request $request,$id)
    {
        
        $user_id = 1;//dummyData
        $comment = Comment::where('user_id',$user_id)->where('id',$id)->count();
        if($comment)
        {
            $comments = Comment::findOrFail($id);
            if($request->has('content'))
            {
                $comments->update(['content'=>$request->content]);
                return response()->json(['$comments']);
            }
            return response()->json(['messsage'=>"Empty Content"]);
        }
        else
        {
            return response()->json(["statuscode"=>404,"message"=>"not found"]);
        }


   
   
    }
    
    
    public function destroy($id)
    {
        $user_id=1;//dummydata
        $comment = Comment::where('id',$id)->where('user_id',$user_id)->count();
        
        if($comment)
        {
        $commentDelete=Comment::findOrFail($id);
        $commentDelete->delete();
        return response()->json(['statuscode'=>3,'message'=>"deleted"]);
        }
        else
        {
            return response()->json(['message'=>"unauthrized"]);
        }
        

    }
}
