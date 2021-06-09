<?php

namespace App\Models;
use App\Models\User;
use App\Models\Image;
use App\Models\Tag;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }
    public function tag()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function like()
    {
        return $this->morphMany(Like::class,'likeable');
    }
}
