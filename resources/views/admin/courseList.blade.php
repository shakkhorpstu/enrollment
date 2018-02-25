@extends('layouts.admin_app')

@section('content')
<div class="row">
<div class="col-md-8 offset-md-2">
          
          @if(Session::has('delete'))
          <div class="alert alert-success" role="alert">
              {{ Session::get('delete') }}
          </div>
          @elseif(Session::has('success'))
          <div class="alert alert-success" role="alert">
              {{ Session::get('success') }}
          </div>
          @endif

          <div class="form-group col-md-4 offset-md-8" style="padding-top: 1em;">
                    <form class="form-group form-inline" action="{{ route('admin.search.course') }}" method="post">
                        {{ csrf_field() }}
                    <input type="text" name="search" class="form-control float-right" placeholder="Search ID">
                    <input type="hidden" name="level" value="{{ $level }}" class="form-control">
                    <input type="hidden" name="semester" value="{{ $semester }}" class="form-control">
                    <button class="btn btn-primary float-right" style="margin-left: .2em;">Search</button>
                </form>
            </div>
            <h2 class="text-center">Course Information</h2>
            <table class="table">
                <thead class="bg-success">
                    <th>#</th>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Course Credit</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                  @if($courses)
                  @php $index = 1; @endphp
                  @foreach($courses as $course)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $course->course_id }}</td>
                        <td>{{ $course->course_title }}</td>
                        <td>{{ $course->credit }}</td>
                        <td>
                        <a href="{{ route('admin.course.edit',$course->course_title) }}" class="btn btn-dark">Edit</a></td>
                        <td>
                        {{ Form::open(['route' => ['admin.course.delete',$course->course_title],'method' => 'DELETE']) }}
                        {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                        </td>
                    </tr>
                    @php $index++; @endphp
                    @endforeach
                    @else
                      <h3>No Course To Show</h3>
                    @endif
                </tbody>
            </table>
    </div>
</div>
@endsection
