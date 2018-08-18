<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Validator;
use Response;
use Auth;
use Session;
use App\Notifications\CommentOnPost;
use Illuminate\Support\Facades\Input;
use App\http\Requests;
use App\User;
use App\Post;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
// recieve data from ajax respone and store in database



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
         'post_id'=>'exists:posts,id|numeric',
         'comment'=>'required|max:255'

         ]);
        $post=Post::find($request->post_id);

        $comment =new Comment;
        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->post_id;
        $user = User::find($post->user_id);
        $comment->save();
        //$user->notify(new CommentOnPost($comment));
        Session::flash('success',' You commented on this post ');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $commentUpdate=Comment::find($id);
        $commentUpdate->comment=$request->comment;
        $commentUpdate->save();




        Session::flash('success','Comment Updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $comment = Comment::find($id);

      $comment->delete();
      Session::flash('success', 'comment was succesfully deleted');
      return redirect()->back();
       }
}
