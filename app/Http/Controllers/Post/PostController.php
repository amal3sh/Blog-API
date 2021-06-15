<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Tag;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $post = Post::all();
       return response()->json($post);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        
        $data['user_id']=3; 
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
        return response()->json([
            "status"=>1,
        "message"=>"Post Created Successfully"]);

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
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
       
        return response()->json([
            "statuscode"=>3,
            "message"=>"Updated Successfully"
        ]);
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
        $post->delete();
        return response()->json(["message"=>"Successfully deleted"]);
    }
}
