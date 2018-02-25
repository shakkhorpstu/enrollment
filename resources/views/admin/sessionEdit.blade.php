@extends('layouts.admin_app')

@section('content')
<div class="container">
<div class="col-md-6 offset-md-3">
    <div style="margin-top: 6em;">
      <h3 class="text-center text-danger">Edit Session</h3>
      {!! Form::model($session,['route'=> ['admin.session.update',$session->id],'method' => 'PUT']) !!}

        <div class="col-md-12">
          {{ Form::label('session','Session',['class' => 'form-label']) }}
          {{ Form::text('session',null,['class' => 'form-control input-lg']) }}

          {{ Form::submit('Save Changes',['class' => 'btn btn-success form-spacing-top float-right']) }}
        </div>
    </div>
    </div>
  </div>
@endsection
