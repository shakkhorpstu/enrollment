@extends('layouts.admin_app')

@section('content')
<div class="container">
<div class="col-md-6 offset-md-3">

        @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif

        <div style="margin-top: 4em;">
          <h3 class="text-center bg-danger card">Edit Course</h3>
          {!! Form::model($course,['route'=> ['admin.course.update',$course->id],'method' => 'PUT']) !!}

          {{ Form::label('course_id','Course Code',['class' => 'form-label']) }}
          {{ Form::text('course_id',null,['class' => 'form-control input-lg']) }}

          {{ Form::label('course_title','Course Title',['class' => 'form-label']) }}
          {{ Form::text('course_title',null,['class' => 'form-control input-lg']) }}

          {{ Form::label('semster','Semester',['class' => 'form-label']) }}
          {{ Form::text('semester',null,['class' => 'form-control input-lg']) }}

          {{ Form::label('credit','Course Credit',['class' => 'form-label']) }}
          {{ Form::text('credit',null,['class' => 'form-control input-lg']) }}

          {{ Form::submit('Save Changes',['class' => 'btn btn-success float-right form-spacing-top']) }}
        </div>
    </div>
</div>
@endsection
