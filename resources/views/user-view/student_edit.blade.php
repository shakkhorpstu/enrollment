@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-md-6 offset-md-3">
      <div class="card card-default">
    <div class="col-md-12"  style="padding-top: 2em;">

      <!-- <div class="row">
        <div class="col-md-6 offset-md-3"> -->

    {{-- @if(Session::has('success'))

    <div class="alert alert-success success-message" role="alert">
        <strong>Success:</strong> {{ Session::get('success') }}
    </div>
    @elseif(Session::has('delete'))
    <div class="alert alert-danger success-message" role="alert">
        <strong>Success:</strong> {{ Session::get('delete') }}
    </div>
    @endif --}}
                <div class="card-heading text-center"><h3>Edit Profile Form</h3></div>

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('updateStudent') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="first_name" value="{{ $student->first_name }}" required autofocus>

                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="last_name" value="{{ $student->last_name }}" required autofocus>

                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Father's Name</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="father_name" value="{{ $student->father_name }}" required autofocus>

                                @if ($errors->has('father_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('father_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Mother's Name</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="mother_name" value="{{ $student->mother_name }}" required autofocus>

                                @if ($errors->has('mother_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mother_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" value="{{ $student->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('faculty_id') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Faculty</label>

                            <div class="col-md-12">
                                <select class="form-control" name="faculty_id" required autofocus>
                                    <option>Select Faculty</option>
                                    @foreach($faculties as $faculty)
                                      @if($faculty->faculty_id == $student->faculty_id)
                                        <option value="{{ $faculty->faculty_id }}" selected>{{ $faculty->faculty_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                {{-- <input id="name" type="text" class="form-control" name="faculty_id" value="{{ old('faculty_id') }}" required autofocus> --}}

                                @if ($errors->has('faculty_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('faculty_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('reg_no') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-12 control-label">Registration Number</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="reg_no" value="{{ $student->registration_no }}" required autofocus>

                                @if ($errors->has('reg_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('reg_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('id_no') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Student ID</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="student_id" value="{{ $student->id_no }}" required autofocus>

                                @if ($errors->has('id_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Session</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="session" value="{{ $student->session }}" required autofocus>

                                @if ($errors->has('session'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('session') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">City</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="city" value="{{ $student->city }}" required autofocus>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('full_address') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Full Address</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="full_address" value="{{ $student->full_address }}" required autofocus>

                                @if ($errors->has('full_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>
    </div>
    <!-- </div>
        </div> -->
@endsection
