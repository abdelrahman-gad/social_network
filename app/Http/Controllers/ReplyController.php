<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Reply;
use App\User;
use App\Comment;
use Validator;
use Response;
use Auth;
use Session;
use App\Notifications\ReplyOnComment;
use Illuminate\Support\Facades\Input;
use App\http\Requests;
class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
       'comment_id'=>'exists:comments,id|numeric',
       'reply'=>'required|max:255'

       ]);

   $reply =new Reply;
   $reply->reply=$request->reply;
   $reply->user_id=Auth::user()->id;
   $reply->post_id=$request->post_id;
   $reply->comment_id=$request->comment_id;


   $reply->save();
   $user = User::find($reply->comment->user_id);
   $user->notify(new ReplyOnComment($reply));
   Session::flash('success',' replied on this comment successfully ');
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
      $replyUpdate=Reply::find($id);
      $replyUpdate->reply=$request->reply;
      $replyUpdate->save();
      Session::flash('success','Reply updated succesfully');
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
        $reply=Reply::find($id);
        $reply->delete();
        Session::flash('success','reply was deleted successfuly');
        return redirect()->back();
    }
}
