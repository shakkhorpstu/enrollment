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
    <link rel="stylesheet" type="text/css" href="{{ URL::to('css/admin_style.css')}}">
    <style type="text/css">
      body{
        background-color: #ffffff;
        font-family: system-ui;
      }
    </style>
    @yield('stylesheets')
</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-lg navbar-dark bg-info">
            <a class="navbar-brand"><h4>PSTU ENROLLMENT</h4></a>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                  @if(Auth::guard('admin')->check())
                  <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.home') }}" style="margin-right: .2em;"><strong>Home</strong></span></a>
                </li>
                @if(Auth::User()->admin_type == 'Master')
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.faculties') }}" style="margin-right: .2em;"><strong>Faculty</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.hallList') }}" style="margin-right: .2em;"><strong>Hall</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.session') }}" style="margin-right: .2em;"><strong>Session</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.admin') }}" style="margin-right: .2em;"><strong>Admin</strong></a>
                </li>
                @endif
                @if(Auth::User()->admin_type == 'Faculty')
                <li class="nav-item">
                    <a class="nav-link text-dark" href="{{ route('admin.addCourse') }}" style="margin-right: .2em;"><strong>Add Course</strong></a>
                </li>
                @endif
            </ul>
            @if(Auth::User()->admin_type != 'Master')
            <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" style="margin-right: .2em;">
                        <strong>{{ "Student List" }}</strong>
                    </a>
                    <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      @php
                        $sessions = DB::table('sessions')->get();
                      @endphp
                      @foreach($sessions as $session)
                        <a class="dropdown-item" href="{{ route('admin.studentlist',$session->session) }}">
                          <strong>{{ $session->session }}</strong>
                        </a>
                      @endforeach
                    </div>
                </li>
            </ul>
                @if(Auth::User()->admin_type == 'Hall')
              <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" style="margin-right: .2em;">
                        <strong>{{ "Unpaid" }}</strong>
                    </a>
                    <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      @php
                      $faculties = DB::table('faculties')->get();
                      @endphp
                      @foreach($faculties as $faculty)
                        <a class="dropdown-item" href="{{ route('admin.hall.unpaid',$faculty->faculty_url) }}">{{ $faculty->faculty_name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" style="margin-right: .2em;">
                        <strong>{{ "Paid" }}</strong>
                    </a>
                    <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      @php
                      $faculties = DB::table('faculties')->get();
                      @endphp
                      @foreach($faculties as $faculty)
                        <a class="dropdown-item" href="{{ route('admin.hall.paid',$faculty->faculty_url) }}">{{ $faculty->faculty_name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
            
              @endif
              @if(Auth::User()->admin_type == 'Faculty')
                <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" style="margin-right: .2em;">
                        <strong>{{ "Enrolled List" }}</strong>
                    </a>
                    <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      @for($lvl=1; $lvl<=4; $lvl++)
                        @for($smstr=1; $smstr<=2; $smstr++)
                        <a class="dropdown-item" href="{{ route('admin.semester.enroll',["level-".$lvl,"semester-".$smstr]) }}">
                          <strong>Level-{{ $lvl }} Semester-{{ $smstr }}</strong>
                        </a>
                        @endfor
                      @endfor
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" style="margin-right: .2em;">
                        <strong>{{ "Completed Enrolled List" }}</strong>
                    </a>
                    <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      @for($lvl=1; $lvl<=4; $lvl++)
                        @for($smstr=1; $smstr<=2; $smstr++)
                        <a class="dropdown-item" href="{{ route('admin.semester.completeEnroll',["level-".$lvl,"semester-".$smstr]) }}">
                          <strong>Level-{{ $lvl }} Semester-{{ $smstr }}</strong>
                        </a>
                        @endfor
                      @endfor
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink"
                      data-toggle="dropdown" aria-haspopup="false" aria-expanded="false" style="margin-right: .2em;">
                        <strong>{{ "Course List" }}</strong>
                    </a>
                    <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      @for($lvl=1; $lvl<=4; $lvl++)
                        @for($smstr=1; $smstr<=2; $smstr++)
                        <a class="dropdown-item" href="{{ route('admin.semester.course',["level-".$lvl,"semester-".$smstr]) }}">
                          <strong>Level-{{ $lvl }} Semester-{{ $smstr }}</strong>
                        </a>
                        @endfor
                      @endfor
                    </div>
                </li>
            </ul>
              @endif
            @endif
            <ul class="navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                      {{ Auth::user()->name }}
                  </a>
                  <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{ route('admin.admin.changePassword') }}">Change Password</a>
                      <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                  </div>
              </li>

              @endif
          </ul>
</div>
</nav>

@yield('content')

<!-- Scripts -->
<script type="text/javascript" src="{{ URL::to('js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/bootstrap.min.js') }}"></script>
<!-- <script src="{{ asset('js/app.js') }}"></script> -->
</body>
</html>
