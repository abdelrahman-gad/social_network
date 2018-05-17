@extends('layouts.app')

@section('content')


<div class="container">
    <!--tis one is subchild of the navbar   -->
<div class="row">
 <div class="col-md-8 col-md-offset-2">
   <div class="panel panel-default">
    <div class="panel-heading">Dashboard</div>
      <div class="panel-body">
       @if (session('status'))
         <div class="alert alert-success">
            {{ session('status') }}
         </div>             
         @endif           

        welcom {{Auth::user()->username}}  
        <img src=" {{Auth::user()->profile_picture}} " alt="profile picture ">  
         <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#posts" aria-controls="posts" role="tab" data-toggle="tab">posts</a></li>
            <li role="presentation"><a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">comments</a></li>
            <li role="presentation"><a href="#categories" aria-controls="categories" role="tab" data-toggle="tab">categories</a></li>
        
        </ul>
    
    <!--  Tab panes  -->
   <div class="tab-content">
      <div role="tabpanel" class="tab-pane active fade in" id="posts">
                            {{ Auth::user()->posts()->count() }} Posts created
                            @foreach (Auth::user()->posts as $post)
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h3 class="panel-title">
                                        {{ $post->title }}
                                        <div class="pull-right">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="{{ route('post.show', [$post->id]) }}">Show Post</a></li>
                                                    @if($post->user_id == Auth::user()->id)
                                                    <li><a href="{{ route('post.edit', [$post->id]) }}">Edit Post</a></li>
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
                                    {{ $post->body }}
                                    <br />
                                    Category: <div class="badge">{{ $post->category->name }}</div>
                                  </div>
                                </div>
                            @endforeach
                        </div>
       <div role="tabpanel" class="tab-pane fade" id="categories">
                            {{ Auth::user()->categories()->count() }} Categoreies created
                            @foreach (Auth::user()->categories as $category)
                                <div class="panel panel-default">
                                  <div class="panel-body">
                                    {{ $category->name }}
                                  </div>
                                </div>
                            @endforeach
                        </div>
 

 <div role="tabpanel" class="tab-pane fade" id="likes">
                            @foreach (Auth::user()->likes as $like)
                                @if ($like->like)
                                    <div class="panel panel-default">
                                      <div class="panel-heading">
                                        <h3 class="panel-title">
                                            Created by {{ $like->post->user->username }}, {{ $like->post->title }}
                                            <div class="pull-right">
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                        <span class="caret"></span>
                                                    </a>

                                                    <ul class="dropdown-menu" role="menu">
                                                        <li><a href="{{ route('post.show', [$like->post->id]) }}">Show Post</a></li>
                                                        <li><a href="{{ route('post.edit', [$like->post->id]) }}">Edit Post</a></li>
                                                        <li>
                                                            <a href="#" onclick="document.getElementById('delete').submit()">Delete Post</a>
                                                            {!! Form::open(['method' => 'DELETE', 'id' => 'delete', 'route' => ['post.delete', $like->post->id]]) !!}
                                                            {!! Form::close() !!}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </h3>
                                      </div>
                                      <div class="panel-body">
                                        {{ $like->post->body }}
                                        @if ($like->post->image != null)
                                            <img src="/images/{{ $like->post->image }}" alt="Image" width="100%" height="600">
                                        @endif
                                        <br />
                                        Category: <div class="badge">{{ $like->post->category->name }}</div>
                                      </div>
                                      <div class="panel-footer" data-postid="{{ $like->post->id }}">
                                        <a href="#" class="btn btn-link like active-like">Like <span class="badge">{{ $like->post->likes()->where('like', '=', true)->count() }}</span></a>
                                        <a href="#" class="btn btn-link like">Dislike <span class="badge">{{ $like->post->likes()->where('like', '=', false)->count() }}</a>
                                         <a href="{{ route('post.show', [$like->post->id]) }}" class="btn btn-link">Comment</a>
                                      </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>











   </div>

 </div>

      </div> 
    </div>
  </div>
 </div>   

</div> 

   <!-- this one  contains links of posts and comments --> 
<div class="row">
    
    
</div> 


   <!--this ione contains the posts  -->
<div class="row">
  
</div>

@endsection

