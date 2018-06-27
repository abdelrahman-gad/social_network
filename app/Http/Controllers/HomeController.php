<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Comment;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'listUser']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $comments=Comment::all();

        return view('home',['commnets'=>$comments]);
    }
    public function listUser() {
        $users = User::orderBy('id', 'desc')->paginate(40);
        return view('user.index')->withUsers($users);
    }

    public function showUser($id) {
        $user = User::find($id);
        return view('user.show')->withUser($user);

    }

    public function getMultiFilterSelect()
       {
           return view('user.index');
       }

       public function getMultiFilterSelectData()
       {
           $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at']);

           return Datatables::of($users)->make(true);
       }


}
