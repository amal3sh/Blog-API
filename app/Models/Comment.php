<?php

namespace App\Models;
use App\Models\Like;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function commentable()
    {
        return $this->morphTo();
    }
   
    public function likes()
    {
        return $this->morpMany(Like::class,'likeable')
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
