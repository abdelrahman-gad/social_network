@extends('layouts.app')
@section('head')
<style media="screen">
  .reply-form{
  display: none;
  }
  .comments{

  }
  .replies{
  color: #888;
  padding-top: 10px;
  padding-bottom:  10px;
  }
  .reply{

  padding-top: 10px;
  padding-bottom:  10px;
  }
.comment-content{
  width: 500px;
  display: inline;
}
.reply-content{
  width: 500px;
  display: inline;
}
.commenter{
  display: inline;
}
.reply-form , .edit-reply-form , .edit-comment-form{
  display: none;
}




</style>
@endsection


@section('content')
    <div class="container">
        <div class="col-sm-10 col-sm-offset-1">
          @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <ul>
                      @foreach ($errors->all() as $error)
                          {{ $error }}
                      @endforeach
                  </ul>
              </div>
          @endif
          @if (Session::has('success'))
              <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  {{ Session::get('success') }}
              </div>
          @endif
            <div class="panel panel-default" style="margin: 0; border-radius: 0;">
              <div class="panel-heading">
                <h3 class="panel-title">
                    {{ $post->title }},

                    <div class="pull-right">
                        <a href="{{ url('/post') }}">Return back</a>
                    </div>
                </h3>
              </div>
              <div class="panel-body">
                <h5>{{ $post->body }}</h5>
                @if ($post->image != null)
                    <img src="{{Request::root().'/post_img/'.$post->image }}" alt="Image" width="100%" height="600">
                @endif
                <br>
                <br>
                Ctegory : <div class="badge">
                  <a  href="{{route('categories.showAll',$post->category_id)}}"  class="badge" >
               {{ $post->category['name']  }}


               </a></div>
              </div>

              <!-- likes dislikes and its count and comments count -->
              <div class="panel-footer" data-postid="{{ $post->id }}">
                @if (Auth::check())
                                  @php
                                      $i = Auth::user()->likes()->count();
                                      $c = 1;
                                      $likeCount = $post->likes()->where('like', '=', 1)->count();
                                      $dislikeCount = $post->likes()->where('like', '=', 0)->count();
                                  @endphp
                                  @foreach (Auth::user()->likes as $like)
                                      @if ($like->post_id == $post->id)
                                          @if ($like->like)
                                              <a   href="{{route('addlike',[$post->id,Auth::user()->id])}}" class="btn btn-link like active-like">Like <span class="badge">{{ $likeCount }}</span></a>
                                              <a   href="{{route('dislike',[$post->id,Auth::user()->id])}}" class="btn btn-link like">Dislike <span class="badge">{{ $dislikeCount }}</span></a>
                                          @else
                                              <a  href="{{route('addlike',[$post->id,Auth::user()->id])}}" class="btn btn-link like">Like <span class="badge">{{ $likeCount }}</span></a>
                                              <a   href="{{route('dislike',[$post->id,Auth::user()->id])}}" class="btn btn-link like active-like">Dislike <span class="badge">{{ $dislikeCount }}</span></a>
                                          @endif
                                          @break
                                      @elseif ($i == $c)
                                          <a  href="{{route('addlike',[$post->id,Auth::user()->id])}}" class="btn btn-link like">Like <span class="badge">{{ $likeCount }}</span></a>
                                          <a  href="{{route('dislike',[$post->id,Auth::user()->id])}}" class="btn btn-link like">Dislike <span class="badge">{{ $dislikeCount }}</span></a>
                                      @endif
                                      @php
                                          $c++;
                                      @endphp
                                  @endforeach
                                  @if ($i == 0)
                                      <a  href="{{route('addlike',[$post->id,Auth::user()->id])}}" class="btn btn-link like">Like <span class="badge">{{ $likeCount }}</span></a>
                                      <a   href="{{route('dislike',[$post->id,Auth::user()->id])}}" class="btn btn-link like">Dislike <span class="badge">{{ $dislikeCount }}</span></a>
                                  @endif
                              @else
                                  <a href="{{ url('login') }}" class="btn btn-link">Like <span class="badge">{{ $likeCount }}</span></a>
                                  <a href="{{ url('login') }}" class="btn btn-link">Dislike <span class="badge">{{ $dislikeCount }}</span></a>
                              @endif

                  <a href="#" class="btn btn-link">Comments <span class="badge"> {{$comments->count()}} </span></a>
              </div>
            </div>

          @foreach($post->comments as $comment )

                <div class="panel panel-default" style="margin: 0; border-radius: 0;">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-9">
                        <p class="comment-content">  {{ $comment->comment  }} </p>
                            @if($comment->user_id == Auth::user()->id)
                            <small class="pull-right" > Commented by <a href="{{route('home')}}">{{ $comment->user['username'] }} </a> </small>

                            @else
                            <small class="pull-right" > Commented by <a href="{{route('users.show',$comment->user_id)}}" >{{ $comment->user['username'] }} </a> </small>

                            @endif


                      </div>
                      <div class="col-sm-3">
                @if(Auth::user()->id == $comment->user_id)

            <span  data-editcomment="{{$comment->id+$post->id}}" class="btn btn-warning btn-sm edit-comment">
            <i  class="fa fa-pencil"></i>
          </span>
          <a class=" btn btn-danger btn-sm" href="#" onclick="document.getElementById('delete').submit()">  <i class="fa fa-trash" >
            {!! Form::open(['method' => 'DELETE', 'id' => 'delete', 'route' => ['comments.delete', $comment->id]]) !!}
            {!! Form::close() !!}

            </i></a>

                @endif
            <div class="pull-right">
              <span  data-srf="{{$comment->id}}"  onclick="showReplyForm({{$comment->id}})"  class="reply btn btn-success btn-sm  ">reply</span>
            </div>
                      </div>

                    </div>
                    <br>

          <div  id="{{$comment->id+$post->id}}"  class="edit-comment-form">
              {!! Form::open(['method'=>'PUT' ,'route' => ['comments.update', $comment->id] ,'style'=>'display:flex' ])  !!}
                {{csrf_field()}}
                <input  type="hidden" name="post_id" value="{{ $post->id }}">
                <input  id="comment_field" type="text" name="comment" value="{{$comment->comment}}" class="form-control" style="border-radius: 0;">
                <input type="submit" value="Update Comment" class="btn btn-primary" style="border-radius: 0;">

                {!! Form::close() !!}
          </div>



                    <br>
@if(!isset($comment->replies))
<h4>replies</h4>
@endif
@foreach( $comment->replies as $reply )

<div class="row replies">

                    <div class="col-sm-12">

                    <div class="replies  col-sm-9">
                      <p class="reply-content ">{{ $reply->reply}} </p>
                      @if($reply->user_id == Auth::user()->id)
                      <small class="pull-right" > Replied by <a href="{{route('home')}}">{{ $reply->user['username'] }} </a> </small>
<br>
                      @else
                      <small class="pull-right" > Replied  by <a href="{{route('users.show',$reply->user_id)}}">{{ $comment->user['username'] }} </a> </small>
<br>
                      @endif

                    </div>

                       <div  class="col-sm-3">
                         @if(Auth::user()->id == $reply->user_id)

                         <span  data-editreply="{{$reply->id}}" class="btn btn-warning btn-sm edit-reply">
                         <i  class="fa fa-pencil"></i>
                       </span>
                       <a class="btn btn-danger btn-sm" href="#" onclick="document.getElementById('rdelete').submit()">  <i class="fa fa-trash" >
                       {!! Form::open(['method' => 'DELETE', 'id' => 'rdelete', 'route' => ['replies.delete', $reply->id]]) !!}
                       {!! Form::close() !!}

                       </i></a>

                         @endif
                       </div>

                  <br>
                  </div>


                  </div>

                  <div  id="{{$reply->id}}" class="edit-reply-form col-sm-10">
                      {!! Form::open(['method'=>'PUT' ,'route' => ['replies.update', $reply->id] ,'style'=>'display:flex' ])  !!}
                        {{csrf_field()}}
                        <input  type="hidden" name="post_id" value="{{ $post->id }}">
                        <input  id="comment_field" type="text" name="reply" value="{{$reply->reply}}" class="form-control" style="border-radius: 0;">
                        <input type="submit" value="Update Reply" class="btn btn-success" style="border-radius: 0;">

                        {!! Form::close() !!}
                  </div>
<br> <br>
      @endforeach







                      <div  id="{{$comment->id}}" class="row reply-form">
                        <br><br>
                        <div class="col-sm-10">

                           <form action="{{ route('replies.store') }}" method="POST" style="display: flex;">
                              {{ csrf_field() }}
                              <input type="text" name="reply" placeholder="reply on post" class="form-control" style="border-radius: 0;">
                              <input type="hidden" name="post_id" value="{{ $post->id }}">
                              <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                              <input type="submit" value="reply" class="btn btn-success" style="border-radius: 0;">
                          </form>

                        </div>

                      </div>
                  </div>
                </div>

       @endforeach



            @if (Auth::check())
                <div class="panel panel-default" style="margin: 0; border-radius: 0;">
                  <div class="panel-body">
                      <form method="POST" action="{{ route('comments.store') }}"   style="display: flex;">



                      {{ csrf_field() }}
                          <input  type="hidden" name="post_id" value="{{ $post->id }}">
                          <input  id="comment_field" type="text" name="comment" placeholder="Enter your Comment" class="form-control" style="border-radius: 0;">
                          <input type="submit" value="Comment" class="btn btn-primary" style="border-radius: 0;">
                      </form>


                  </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('footer')
<script type="text/javascript">
// show reply input field
$('.reply').on('click',function(){

  $('#'+$(this).data('srf')).slideToggle();
});



$('.edit-reply').on('click',function(){
  console.log($(this).data('editreply'));
  $('#'+$(this).data('editreply')).slideToggle();
});

$('.edit-comment').on('click',function(){
  console.log($(this).data('editcomment'));
  $('#'+$(this).data('editcomment')).slideToggle();
});

</script>

@endsection
