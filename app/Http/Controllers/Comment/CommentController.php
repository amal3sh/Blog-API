<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends ApiController
{
    public function update(Request $request,$id)
    {
        
        $user_id = 3;//dummyData
        $comment = Comment::where('user_id',$user_id)->where('id',$id)->count();
        if($comment)
        {
            $comments = Comment::findOrFail($id);
            if($request->has('content'))
            {
                $comments->update(['content'=>$request->content]);
                return $this->successResponse("COmment Updated",200);
            }
            else
            {
            return $this->errorResponse("Comment body is blank",204);
            }
        }
        else
        {
            return $this->errorResponse("Not Found",404);
        }


   
   
    }
    
    
    public function destroy($id)
    {
        $user_id=3;//dummydata
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
