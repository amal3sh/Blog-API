<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
   protected $guarded = [];
   
   
    public function user()
    {
        return $this->belongsToOne(User::class);
    }
    public function likeable()
    {
        return $this->mophTo();
    }
}
