@extends('layouts.admin_app')

@section('content')
        <div class="col-md-10 offset-md-1"><div class="form-group col-md-4 offset-md-8" style="padding-top: 1em;">
                    <form class="form-group form-inline" action="{{ route('admin.search.studentList') }}" method="post">
                        {{ csrf_field() }}
                    <input type="text" name="student_id" class="form-control float-right" placeholder="Search ID">
                    <input type="hidden" name="session" value="{{ $session }}" class="form-control">
                    <button class="btn btn-success float-right" style="margin-left: .2em;">Search</button>
                </form>
            </div>

          <h2 class="text-center">Student Information</h2>
            <table class="table border">
                <thead class="text-success">
                    <th>#</th>
                    <th>Name</th>
                    <th>Faculty</th>
                    <th>ID</th>
                    <th>Session</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @php $index = 1; @endphp
                    @foreach($students as $student)
                    <tr>
                        <td>{{ $index }}</td>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->faculty->faculty_name }}</td>
                        <td>{{ $student->id_no }}</td>
                        <td>{{ $student->session}}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->city }}</td>
                        <td>
                          <a type="button" class="btn btn-primary" href="{{ route('admin.student.details', $student->id_no) }}">Details</a>
                        </td>
                        <td>
                            {{ Form::open(['route' => ['admin.students.delete',$student->id],'method' => 'DELETE']) }}
                            {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </td>
                    </tr>
                    @php $index++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
