@extends('layouts.app')

@section('content')
<div class="container">
  <div class="container">
    <div class="col-sm-9 ">
    @if(Session::has("success"))
    <div class="alert alert-success">
    <a href="#" class="close">&times; </a>
    {{  Session::get("success") }}
    </div>
    @endif
    <form method="post" action="" enctype="multipart/form-data" >
      
     {{csrf_field()}}
    <div class="panel panel-default">
                <div class="panel-body">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                <input type="text" name="title" class="form-control" placeholder="Enter your post title">
                @if ($errors->has('title'))
                    <small class="text-danger">{{ $errors->first('title') }}</small>
                @endif
            </div>
                        
            <div class="form-group">
            <input type="file"   name="image">
            </div>
                        
            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
            <textarea name="body" rows="8" cols="80" class="form-control" placeholder="Enter your post"></textarea>
            @if ($errors->has('body'))
                <small class="text-danger">{{ $errors->first('body') }}</small>
            @endif
          </div>

                      
          <div class="form-group">
          <label for="category"></label>
           <select name="category" value="" class="form-control" id=""> 
            @foreach( $categories as $category)
            <option value=" {{$category->id}} "> {{$category->name}} </option>             
 

            @endforeach     
            

            </select>
            </div>
          <input type="submit" class="btn btn-primary btn-block">
      </div>
    </div>


      
    </form>--
    </div>
    <!-- Links of Category -->
    <div class="col-sm-3">
     @foreach($categories as $category)  
     <a href=" {{route('category.showAll',[$category->name] ) }}  " class="badge"> {{$category->name}} </a>
     @endforeach
    </div>

    </div>

<div class="container ">
    <div class="col-sm-9 ">
       @foreach($posts as $post)    
   <div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="panel-title">
    Created by {{$post->user['username'] }} ,    {{$post->title}}
        <div class="pull-right">
        
        <div class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
               <span class="caret"></span>
          </a>

          <ul class="dropdown-menu" role="menu">
            <li> <a href=" {{route('post.show',[$post->id])}}  ">Show Post</a></li>
            @if($post->user_id == Auth::user()->id)
            <li> <a href=" {{route('post.edit',[$post->id])}} ">Edit Post</a> </li>  
            <!-- <li> <a href="#" onclick="document.getElementById('delete').submit()" >Delete Post</a>
            {!!Form::open(['method'=>'DELETE','id'=>'delete','route'=>['post.delete',$post->id]])  !!}
            
            {!!Form::close()  !!}
             </li>   -->
           
             <li>
            <a href="#" onclick="document.getElementById('delete').submit()">Delete Post</a>
            {!! Form::open(['method' => 'DELETE', 'id' => 'delete', 'route' => ['post.delete', $post->id]]) !!}
            {!! Form::close() !!}
            </li>
            @endif
          </ul>
      </div>                       
        </div>

    </h3>
    </div>
    <div class="panel-body">
     {{$post->body}}

     @if ($post->image != null)
     <img src="{{Request::root().'/post_img/'.$post->image }}" alt="Image" width="100%" height="400">
     @endif
    <br>


 Ctegory : <div class="badge">
{{ $post->category['name']  }}
</div>
    </div>

    <div class="panel-footer" data-postid="{{ $post->id }}">
                     
                     
                     
     <a href="#" class="btn btn-link like">Like </a>
     <a href="#" class="btn btn-link like">Dislike </a>
     <a href="{{ route('post.show', [$post->id]) }}" class="btn btn-link">Comment</a>
                  </div>

   </div>

@endforeach

    </div> 
  

  </div>
  

    </div>
  

    

@endsection
