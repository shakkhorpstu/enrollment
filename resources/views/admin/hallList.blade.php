@extends('layouts.admin_app')

@section('content')
<div class="col-md-8 offset-md-2">
    <div class="row">
        <div class="col-md-8">
          <h2 class="text-center" style="padding-top: 1em;">Hall Information</h2>
            <table class="table">
                <thead>
                    <th><h4>#</h4></th>
                    <th><h4>Hall Name</h4></th>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach($halls as $hall)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $hall->hall_name }}</td>
                        <td>
                        <a href="{{ route('admin.hall.edit',$hall->id) }}" class="btn btn-primary">Edit</a></td>
                        <td>
                        {{ Form::open(['route' => ['admin.hall.delete',$hall->id],'method' => 'DELETE']) }}
                        {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                        </td>
                    </tr>
                    @php $index++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-4">
        <h4 style="padding-top: 1.4em;">Add Hall</h4>
        <!-- <div class="card"> -->
        <form method="post" action="{{ route('admin.addHall') }}">
          {{csrf_field()}}
        <div class="form-group row{{ $errors->has('hall_name') ? ' has-error' : '' }}">
          <div class="col-sm-12">
        <input type="text" class="form-control form-control-lg" value="{{ old('hall_name') }}" placeholder="Hall Name" name="hall_name" required="" maxlength="255">
          </div>
            @if ($errors->has('hall_name'))
                <span class="help-block">
                    <strong style="padding-left: .8em;" class="text-danger">{{ $errors->first('hall_name') }}</strong>
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
