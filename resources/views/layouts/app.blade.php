<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css+">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta id="token" name="token" content="{{ csrf_token() }}">
<style type="text/css" media="screen">

tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    .active-like
    {
        text-decoration: underline;
        color: #222;

     }
.panel
{
    word-break: break-all;
}
.img{
    margin-left:100px;
    }
.unread{
  background-color: #e5e5e5;
}

</style>
  @yield('head')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                              Notifications {{count(auth()->user()->unreadNotifications)}}  <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                         @foreach( auth()->user()->notifications as $note)
                              <li>  <a href="{{ route('post.show', [$note->data['post_id']]) }}"  class="{{$note->read_at == null ? 'unread':''}}" >  {!! App\User::find($note->data['commenter'])->username   !!}  {!!   $note->data['formula']   !!}</a>  </li>
                              <?php $note->markAsRead();  ?>
                          @endforeach
                            </ul>
                        </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                  <li> <a href=" {{url('/home')}} ">My Profile</a></li>
                                  <li> <a href=" {{url('/post')}} ">Posts</a> </li>
                                  <li> <a href=" {{url('/category')}} ">Categories</a> </li>
                                   <li> <a href=" {{url('/users')}} ">Users</a> </li>

                                      <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>



                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
{{--
// likes

// $('.like').click(function(e){
//  e.preventDefault();
//  console.log(e);
//  var Like= e.target.previousElementSibling == null;
//  var postid= e.target.parentNode.dataset['postid'];

//  var data={
//    islLike: Like,
//    user_id: {{ Auth::user()->id }},
//    post_id: postid
//  }


// axios.post('/like', data ).then( response => {
//     console.log(response['data']);
//    })
//  });


 //jquery of add friend link
 --}}
$('.friend').click(function(e) {
    e.preventDefault();
    var friendid = e.target.parentNode.dataset['friendid'];
    var data = {
        friend_id: friendid
    }
    axios.post('/friend', data).then(response => {
        e.target.innerHTML = "Remove Friend";
        e.currentTarget.className = "btn btn-link remove-friend";
    });
})


    </script>

@yield('footer')
</body>
</html>
