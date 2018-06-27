<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
   protected $table='replies';
   protected $fillable=[];
   public function category()
   {
       return $this->belongsTo('App\Category');
   }
   public function user()
   {
       return $this->belongsTo('App\User');
   }
   public function post()
   {
    return $this->belongsTo('App\Post');
   }
   public function comment()
   {
    return $this->belongsTo('App\Comment');
   }
}
