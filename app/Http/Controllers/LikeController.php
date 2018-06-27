<?php

namespace App\Http\Controllers;
use App\Comment;
use Illuminate\Http\Request;
use App\Like;
use Auth;

class LikeController extends Controller
{
    public function index(Request $request) {
      return ['status'=>'ok route is working'];
    }
    public function addLike( $postId,$userId){
     $likes=Like::all()->where('user_id','=',$userId)->where('post_id','=',$postId)->first();
    if($likes==null){
        $like= new Like;
        $like->user_id=$userId;
        $like->post_id=$postId;
        $like->like=1;
        $like->save();
    }else{
        $likes->like=1;
        $likes->save();
    }
return redirect()->back()->with('you liked this post successfully');

    }
    public function disLike( $postId,$userId){
        $likes=Like::all()->where('user_id','=',$userId)->where('post_id','=',$postId)->first();
        if($likes==null){
            $like= new Like;
            $like->user_id=$userId;
            $like->post_id=$postId;
            $like->like=0;
            $like->save();
        }else{
            $likes->like=0;
            $likes->save();
        }
    return redirect()->back()->with('you disliked this post successfully');

    }
}
