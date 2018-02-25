@extends('layouts.app')

@section('content')
<div class="container">
<div id="form_number">
  <div class="row" style="padding-top: 2em;">
    <div class="col-md-6 offset-md-3">

      @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
      @elseif(Session::has('complete-message'))
        <div class="alert alert-danger" role="alert">
            <h3>{{ Session::get('complete-message') }}</h3>
        </div>
      @endif

<form method="POST" action="{{ route('enrollform.repeat') }}" class="form-horizontal" role="form">

  <div class="form-group">
    <label><h4><strong>Student Name</strong></h4></label>
    {{csrf_field()}}
    <input type="text" class="form-control" value="{{ Auth::User()->first_name }} {{ Auth::User()->last_name }}" disabled/>
  </div>

  <div class="form-group">
    <label><h4><strong>Student ID</strong></h4></label>
    <input type="text" class="form-control" value="{{ Auth::User()->id_no }}" disabled/>
  </div>

  <div class="form-group">
    <label><h4><strong>Semester</strong></h4></label>
    <select name="level_semester" class="form-control">
      <option value="1-1">Level-1 Semester-1</option>
      <option value="1-2">Level-1 Semester-2</option>
      <option value="2-1">Level-2 Semester-1</option>
      <option value="2-2">Level-2 Semester-2</option>
      <option value="3-1">Level-3 Semester-1</option>
      <option value="3-2">Level-3 Semester-2</option>
      <option value="4-1">Level-4 Semester-1</option>
      <option value="4-2">Level-4 Semester-2</option>
      @if(Auth::User()->faculty == "Disaster Management")
      <option value="5-1">Level-5 Semester-1</option>
      @endif
    </select>
  </div>

  <div class="form-group">
    <label><h4><strong>Student Email</strong></h4></label>
    <input type="text" class="form-control" value="{{ Auth::User()->email }}" disabled/>
  </div>

  <button type="submit" class="btn btn-info" style="float: right;">Go To Course</button><br>
</form>

</div>
</div>
</div>
</div>

@endsection
