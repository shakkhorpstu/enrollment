@extends('layouts.admin_app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-6 offset-md-3" style="padding-top: 5em;">
            @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
            @endif
        <h2 class="text-center text-success">Add Course</h2>

        <form method="post" action="{{ route('admin.storeCourse') }}">

        <div class="form-group row">
        {{csrf_field()}}
        <div class="col-lg-12">
        <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Course Code" name="course_code" required="" maxlength="255">
            </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-12">
         <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Course Title" name="course_title" required="" maxlength="255">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-12">
         <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="Course Credit" name="course_credit" required="" maxlength="255">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-12">
         <input type="submit" class="btn btn-success col-md-3" value="Add" style="float: right;">
          </div>
        </div>
        </form>
    </div>
</div>
</div>
@endsection
