@extends('layouts.app')
@section('content')
<div class="container">
@if (Session::has('success'))
<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    {{ Session::get('success') }}
</div>
@endif
 <div class="col-sm-6">
            @foreach ($categories as $category)
                <div class="panel panel-default">
                <div class="panel-body">            
                    <a href=" {{route('categories.showAll',[$category->id] ) }}  "> {{ $category->name }}</a>
                </div>
                <div class="panel-footer">
                    <small>Created by     
                    @if(auth()->user()->id == $category->user_id)
                    <a href="{{ route('home')}}">  {{ $category->user->username }} </a>
                    @else
                    <a href="{{ route('users.show',[$category->user->id]) }}">  {{ $category->user->username }} </a>
                    @endif
                    </small>
                </div>
                </div>
            @endforeach
 </div>
 <div class="col-sm-6">
        <div class="well">
        <form action="" method="post"  >
         {{--  cross site request forgery  _token field --}} 
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name control-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter your category name" name="name">
            @if ($errors->has('name'))
                <small class="text-danger">{{ $errors->first('name') }}</small>
            @endif
        </div>
        <input type="submit" value="Submit" class="btn btn-success btn-block">
        </form>
        </div>
 </div>
</div>
@endsection
