<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Tag;
use App\Models\Post;

class PostController extends ApiController
{
   
   
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth:api',['only'=>['store','update','destroy']]);
    }
    public function index()
    {
       $post = Post::all();
       return $this->showAll($post);
    }

    
    private function createOrFetch($taglist)
    {
        $tags=[];
        foreach(explode(',',$taglist) as $taglabel)
        {
            $tag = Tag::firstOrCreate(['label'=>$taglabel]);
            if($tag)
            {
                $tags[]=$tag->id;
            }



        }
        return $tags;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $data= $request->only(['title','content']);
        
        $data['user_id']=auth()->user()->id;
        $post=Post::create($data);
        if($request->has('image'))
        {
            $image = $request->file('image')->store('public/postimages');
            $post->image()->create(['url'=>$image]);

        }
        if($request->has('tags'))
        {

            $tags = $this->createOrFetch($request->tags);
            $post->tags()->attach($tags);

        }
        return $this->successResponse("Post Created",200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return $this->showOne($post);
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post=Post::findOrFail($id);
        if($post->user_id != auth()->user()->id) 
        {
            return $this->errorResponse("You dont have permission to update this post",409);
        }
        $post->title = !empty($request->title)?$request->title:$post->title;
        $post->content = !empty($request->content)?$request->content:$post->content;
        $post->update();
        
        if($request->has('tags'))
        {
            $tags = $this->createOrFetch($request->tags); 
            $post->tags()->sync($tags);
        }
        if($request->has('image'))
        {
            $image = $request->file('image')->store('public/postimages');
            $post->image()->updateOrCreate(['url'=>$image]);


        }
       
        return $this->successResponse("Updated Successfully",200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
       
        if($post->user_id != auth()->user()->id) 
        {
            return $this->errorResponse("You dont have permission to delete this post",409);
        }
       
        $post->delete();
       
        return $this->showOne($post);
    }
}
