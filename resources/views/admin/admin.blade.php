@extends('layouts.admin_app')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-8 offset-md-1">
          <h2 class="text-center" style="padding-top: 1em;"></h2>
            <table class="table">
                <thead>
                    <th><h4>#</h4></th>
                    <th><h4>Name</h4></th>
                    <th><h4>Type</h4></th>
                    <th class="text-center"><h4>Section</h4></th>
                    <th class="text-center"><h4>Email</h4></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->admin_type }}</td>
                        <td>{{ $admin->admin_faculty }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                        {{ Form::open(['route' => ['admin.admin.delete',$admin->id],'method' => 'DELETE']) }}
                        {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-3">
        <h4 style="padding-top: 1.4em;">Add Admin</h4>
        <!-- <div class="card"> -->
        <form method="post" action="{{route('admin.admin.store')}}">
          {{csrf_field()}}
        <div class="form-group row{{ $errors->has('admin_name') ? ' has-error' : '' }}">
          <div class="col-sm-12">
            <input type="text" class="form-control form-control-lg" value="{{ old('admin_name') }}" placeholder="Admin Name" name="admin_name" required="" maxlength="255">
              </div>
                @if ($errors->has('admin_name'))
                    <span class="help-block">
                        <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('admin_name') }}</strong>
                    </span>
                @endif
          </div>

        <div class="form-group row{{ $errors->has('admin_type') ? ' has-error' : '' }}">
          <div class="col-sm-12">
            <select class="form-control" name="admin_type">
              <option>Select Admin Type</option>
              <option value="Master">Master</option>
              <option value="Faculty">Faculty</option>
              <option value="Hall">Hall</option>
            </select>
              </div>
                @if ($errors->has('admin_type'))
                    <span class="help-block">
                        <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('admin_type') }}</strong>
                    </span>
                @endif
          </div>

        <div class="form-group row{{ $errors->has('admin_section') ? ' has-error' : '' }}">
          <div class="col-sm-12">
           <input type="text" class="form-control form-control-lg" placeholder="Admin Section" name="admin_section" required="" maxlength="255">
            </div>
            @if ($errors->has('admin_section'))
                <span class="help-block">
                    <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('admin_section') }}</strong>
                </span>
            @endif
         </div>

         <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
          <div class="col-sm-12">
            <input type="email" class="form-control form-control-lg" value="{{ old('email') }}" placeholder="Admin Email" name="email" required="" maxlength="255">
              </div>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('email') }}</strong>
                    </span>
                @endif
          </div>

          <div class="form-group row{{ $errors->has('password') ? ' has-error' : '' }}">
          <div class="col-sm-12">
            <input type="password" class="form-control form-control-lg" value="{{ old('password') }}" placeholder="Password" name="password" required="" maxlength="255">
              </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('password') }}</strong>
                    </span>
                @endif
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
