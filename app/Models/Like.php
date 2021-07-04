<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
   protected $guarded = [];
   protected $fillable=[
       'user_id',
        'likeable_id',
        'likeable_type'
   ];
   
   
    public function users()
    {
        return $this->belongsToOne(User::class);
    }
    public function likeables()
    {
        return $this->mophTo();
    }
}
