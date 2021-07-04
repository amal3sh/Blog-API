<?php

namespace App\Models;
use App\Models\User;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Comment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $fillable =[
        "title",
        "content",
        "user_id"
    ];


    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
