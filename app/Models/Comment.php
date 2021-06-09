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
   
    public function like()
    {
        return $this->morpMany(Like::class,'likeable')
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reply()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
