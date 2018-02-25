@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row" style="padding-top: 2em;">
    <div class="col-md-8 offset-md-3">
        @for($lvl=1; $lvl<=5; $lvl++)
          @for($smstr=1; $smstr<=2; $smstr++)
          <a type="button" class="col-md-4 btn btn-dark" href="{{ route('user.faculties.courses',
          [$ids,"level-".$lvl,"semester-".$smstr]) }}" style="margin-right: 3em; margin-bottom: 1em; padding: 2em;">
          Level-{{ $lvl }} Semester-{{ $smstr }}</a>
          @endfor
        @endfor
      </div>
    </div>
  </div>
@endsection
