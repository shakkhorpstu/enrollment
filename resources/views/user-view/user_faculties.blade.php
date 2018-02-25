@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row" style="padding-top: 2em;">
    <div class="col-md-9 offset-md-2">
      	@foreach($faculties as $faculty)
          <a type="button" class="col-md-5 btn btn-dark" href="{{ route('user.faculties.semester',$faculty->faculty_url) }}"
            style="margin-right: 3em; margin-bottom: 1em; padding: 2em;">
            {{ $faculty->faculty_name }}</a>
        @endforeach
    </div>
  </div>
</div>
@endsection
