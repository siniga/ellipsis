<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function comments(){
    
        return $this->hasMany('App\Models\Comment');
    }
  
    public function likes(){
    
        return $this->hasMany('App\Models\Like');
    }

    public function favourites(){
    
        return $this->hasMany('App\Models\Favourite');
    }

    public function genres(){
    
        return $this->belongsTo('App\Models\Genre');
    }
  
}

