@extends('layouts.app')

@section('content')
<div class="container">
    <div class="col-md-12"  style="padding-top: 5em;">

      <!-- <div class="row">
        <div class="col-md-6 offset-md-3"> -->
{{-- 
    @if(Session::has('success'))

    <div class="alert alert-success success-message" role="alert">
        <strong>Success:</strong> {{ Session::get('success') }}
    </div>
    @elseif(Session::has('delete'))
    <div class="alert alert-danger success-message" role="alert">
        <strong>Success:</strong> {{ Session::get('delete') }}
    </div>
    @endif --}}

    @if(count($errors) > 0)
     @foreach($errors->all() as $error)
        <p class="alert alert-danger">{{ $error }}</p>
    @endforeach  
@endif
        <div class="col-md-6 offset-md-3">
            <div class="card card-default">
                <div class="card-heading text-center"><h3>Register Form</h3></div>

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('submit.student') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">First Name</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

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
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

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
                                <input type="text" class="form-control" name="father_name" value="{{ old('last_name') }}" required autofocus>

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
                                <input type="text" class="form-control" name="mother_name" value="{{ old('mother_name') }}" required autofocus>

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
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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
                                        <option value="{{ $faculty->faculty_id }}">{{ $faculty->faculty_name }}</option>
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
                                <input type="text" class="form-control" name="reg_no" value="{{ old('reg_no') }}" required autofocus>

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
                                <input type="text" class="form-control" name="student_id" value="{{ old('id_no') }}" required autofocus>

                                @if ($errors->has('id_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('hall_id') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Hall</label>

                            <div class="col-md-12">
                                <select class="form-control" name="hall_id" required autofocus>
                                    <option>Select Hall</option>
                                    @foreach($halls as $hall)
                                        <option value="{{ $hall->id }}">{{ $hall->hall_name }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('hall_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hall_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('hall_alot_id') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Hall Allotment ID</label>

                            <div class="col-md-12">
                                <input type="text" class="form-control" name="hall_allot_id" value="{{ old('hall_alot_id') }}" required autofocus>

                                @if ($errors->has('hall_alot_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('hall_alot_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Session</label>

                            <div class="col-md-12">
                                <select class="form-control" name="session" required autofocus>
                                    <option>Select Session</option>
                                    @foreach($sessions as $session)
                                        <option value="{{ $session->session }}">{{ $session->session }}</option>
                                    @endforeach
                                </select>
                                {{-- <input id="name" type="text" class="form-control" name="faculty_id" value="{{ old('faculty_id') }}" required autofocus> --}}

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
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}" required autofocus>

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
                                <input type="text" class="form-control" name="full_address" value="{{ old('full_address') }}" required autofocus>

                                @if ($errors->has('full_address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('full_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-12 control-label">Confirm Password</label>

                            <div class="col-md-12">
                                <input type="password" class="form-control" name="password_confirmation" required>
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
