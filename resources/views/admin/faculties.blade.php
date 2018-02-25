@extends('layouts.admin_app')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6 offset-md-1">
          <h2 class="text-center" style="padding-top: 1em;"></h2>
            <table class="table">
                <thead>
                    <th><h4>#</h4></th>
                    <th><h4>Faculty Name</h4></th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($faculties as $faculty)
                    <tr>
                        <td>{{ $faculty->faculty_id }}</td>
                        <td>{{ $faculty->faculty_name }}</td>
                        <td>
                        <a href="{{ route('admin.faculties.edit',$faculty->faculty_id) }}" class="btn btn-primary">Edit</a></td>
                        <td>
                        {{ Form::open(['route' => ['admin.faculties.delete',$faculty->faculty_id],'method' => 'DELETE']) }}
                        {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-4 offset-md-1">
        <h4 style="padding-top: 1.4em;">Add Faculty</h4>
        <!-- <div class="card"> -->
        <form method="post" action="{{route('admin.faculties.store')}}">
          {{csrf_field()}}
        <div class="form-group row{{ $errors->has('faculty_name') ? ' has-error' : '' }}">
          <div class="col-sm-12">
        <input type="text" class="form-control form-control-lg" value="{{ old('faculty_name') }}" placeholder="Faculty Name" name="faculty_name" required="" maxlength="255">
          </div>
            @if ($errors->has('faculty_name'))
                <span class="help-block">
                    <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('faculty_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group row{{ $errors->has('faculty_id') ? ' has-error' : '' }}">
          <div class="col-sm-12">
         <input type="text" class="form-control form-control-lg" placeholder="Faculty ID" name="faculty_id" required="" maxlength="255">
          </div>
          @if ($errors->has('faculty_id'))
              <span class="help-block">
                  <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('faculty_id') }}</strong>
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
