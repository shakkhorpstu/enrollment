@extends('layouts.admin_app')

@section('content')
<div class="container">
<div class="col-md-6 offset-md-3">
    <div style="margin-top: 6em;">
      <h3 class="text-center text-danger">Edit Faculty</h3>
      {!! Form::model($faculty,['route'=> ['admin.faculties.update',$faculty->id],'method' => 'PUT']) !!}

        <div class="col-md-12">
          {{ Form::label('faculty_name','Faculty Name:',['class' => 'form-label']) }}
          {{ Form::text('faculty_name',null,['class' => 'form-control input-lg']) }}

          {{ Form::label('faculty_id','Faculty ID:',['class' => 'form-label']) }}
          {{ Form::text('faculty_id',null,['class' => 'form-control input-lg']) }}

          {{ Form::submit('Save Changes',['class' => 'btn btn-success form-spacing-top float-right']) }}
        </div>
    </div>
    </div>
  </div>

    {{-- npm install vue --save --}}


   <!-- <div class="row">
      <form method="post" action="{{route('admin.faculties.update', $faculty->id)}}">

        <div class="form-group row">
        {{csrf_field()}}
        <label for="lgFormGroupInput" class="col-sm-6 col-form-label col-form-label-lg">Faculty Name</label>
        <div class="col-sm-12">
          <div class="col-md-6">
            <input type="text" class="form-control form-control-md" id="lgFormGroupInput" placeholder="Faculty Name" name="faculty_name" required="" maxlength="255" value="{{ $faculty->faculty_name }}">
          </div>
          </div>
        </div>

        <div class="form-group row">
        <label for="smFormGroupInput" class="col-sm-6 col-form-label col-form-label-sm">Faculty ID</label>
          <div class="col-sm-12">
         <div class="col-md-6">
            <input type="text" class="form-control form-control-md" id="lgFormGroupInput" placeholder="Faculty ID" name="faculty_id" required="" maxlength="2" value="{{ $faculty->faculty_id }}">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-9"></div>
          <input type="submit" class="btn btn-primary" value="Submit">
        </div>
        </form>
    </div> -->
  <!-- </div>
</div> -->
@endsection
