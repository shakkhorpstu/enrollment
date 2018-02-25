@extends('layouts.app')

@section('content')
<!-- @if ($errors->any())
  @foreach ($errors->all() as $error)
    <p class="text-danger">{{ $error }}</p>
    @endforeach
@endif -->
<div class="container">
<div id="form_number">
  <div class="row">
<div class="col-md-6 offset-md-3" style="padding-top: 3em;">
  <div class="card card-default">
    <div class="card-heading"><h3 class="text-center">Password Change</h3>
      <div class="card-body">

  @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
  @endif

<form method="POST" action="{{ route('submit.changePassword') }}" class="form-horizontal" role="form">

  <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
    {{csrf_field()}}
    <label>Current Password</label>
    <input type="password" class="form-control" value="" name="current_password">
    @if ($errors->has('current_password'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('current_password') }}</strong>
        </span>
    @endif
    @if(Session::has('alert'))
        <span class="help-block">
            <strong class="text-danger">{{ Session::get('alert') }}</strong>
        </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
    <label>New Password</label>
    <input type="password" class="form-control" value="" name="new_password">
    @if ($errors->has('new_password'))
        <span class="help-block">
            <strong class="text-danger">{{ $errors->first('new_password') }}</strong>
        </span>
    @endif
  </div>

  <div class="form-group">
    <label>Confirm Password</label>
    <input type="password" class="form-control" value="" name="password_confirmation">
    @if(Session::has('not_match'))
        <span class="help-block">
            <strong class="text-danger">{{ Session::get('not_match') }}</strong>
        </span>
    @endif
  </div>

  <button type="submit" class="btn btn-primary float-right">Change Password</button><br>
</form>

            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>

@endsection
