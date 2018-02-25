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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::to('css/bootstrap.min.css')}}"> --}}
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/style.css')}}">
    <style type="text/css">
      body{
        background-color: #ffffff;
        /*font-family: cursive;*/
        /*font-family: "Times New Roman", Georgia, Serif;*/
        /*font-family: monospace;*/
        font-family: system-ui;
      }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
            <a class="navbar-brand"><h4>PSTU ENROLLMENT</h4></a>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                  @if (Auth::guest())
                    <h4><li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li></h4>
                    <h4><li class="nav-item"><a class="nav-link" href="{{ route('studentform') }}">Register</a></li></h4>
                  @elseif(Auth::check())
                <li class="nav-item">
                    <h5><a class="nav-link" href="{{route('enrollform')}}">EnrollmentForm</a></h5>
                </li>
                <li class="nav-item">
                    <h5><a class="nav-link" href="{{ route('user.faculties') }}">Faculties</a></h5>
                </li>
            </ul>
            <ul class="navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ Auth::user()->first_name }}  {{ Auth::user()->last_name }}
                  </a>
                  <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{ route('user.profile') }}">Profile</a>
                      <a class="dropdown-item" href="{{ route('user.changePassword') }}">Change Password</a>
                      <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                  </div>
              </li>
              @endif
          </ul>
      </div>
  </nav>

  @yield('content')

  <div style="padding-top: 2em; height: 5em;">
  <div class="card bg-dark" style="height: 10em;">
  <div class="col-md-6 offset-md-3">
    <h5 class="text-danger footer-bottom">@copyright all right reserved by Patuakhali Science & Technology University</h5>
  </div>
  </div>
</div>
</div>

@yield('scripts')
<!-- Scripts -->
<script type="text/javascript" src="{{ URL::to('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/bootstrap.min.js') }}"></script>
<!--  <script src="{{ asset('js/app.js') }}"></script>  -->
</body>
</html>
