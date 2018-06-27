<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Session;
use Auth;
use App\Post;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
       return view('category.index')->withCategories($categories);
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
    // public function store(Request $request)
    // {
    //  $this-validate($request,
    //  [
    //      'name'=>'required|unique:categories|max:255'
    //  ]);
    //     $category=new Category;
    //     $category->name = strtolower($request->name);
    //     $category->user_id=Auth::user()->id;
    //     $category->save();
    //     Session::flash('success','Category is added successfully');

    //     return redirect('/category');


    // }


    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|unique:categories|max:255'
        ]);
        $category = new Category;
        $category->name = strtolower($request->name);
        $category->user_id = Auth::user()->id;
        $category->save();

        Session::flash('success', 'Category was added succesfully');
        return redirect('/category');
    }


public function showAll($id)
{
 $category=Category::all()->where('id','=',$id)->first();
if($category != null)
{
    $posts=Post::all()->where('category_id','=',$category->id)->sortByDesc('id');
    return view('category.showAll')->withPosts($posts);
}
return redirect('/post');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
