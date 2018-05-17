<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function post()
    {
         return $this->hasMany('App\Post'); 
    }
   public function user()
   {
       return $this->belongsTo('App\User');
   }

}
