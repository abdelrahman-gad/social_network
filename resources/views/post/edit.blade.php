@extends('layouts.app')
@section('content')
<div class="container">
<div class="col-sm-9 ">
    @if(Session::has("success"))
    <div class="alert alert-success">
    <a href="#" class="close">&times; </a>
    {{  Session::get("success") }}
    </div>
    @endif

  {!! Form::model($post,['method'=>'PUT' ,'files'=>true ])  !!}
      {{csrf_field()}}
    <div class="panel panel-default">
                <div class="panel-body">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                {{ Form::text('title',null,['class'=>'form-control','placeholder'=>'Enter title'] )}}
                @if ($errors->has('title'))
                    <small class="text-danger">{{ $errors->first('title') }}</small>
                @endif
            </div>

            <div class="form-group">
            <input type="file"   name="image">
            </div>

            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
            {{ Form::textarea('body',null,['class'=>'form-control','placeholder'=>'Enter Post pls'] )}}
            @if ($errors->has('body'))
                <small class="text-danger">{{ $errors->first('body') }}</small>
            @endif
          </div>


          <div class="form-group">
          <select class="form-control" name="category">
              @foreach ($categories as $category)
                  <option value="{{ $category->id }} {{ $category->id == $post->category_id ? 'selected' : '' }}">{{ $category->name }}</option>
              @endforeach
          </select>
        </div>
          <input type="submit" class="btn btn-primary btn-block">
      </div>
    </div>


   {!! Form::close() !!}


</div>

@endsection
