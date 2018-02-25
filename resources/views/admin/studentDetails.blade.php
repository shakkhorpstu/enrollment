@extends('layouts.admin_app')

@section('content')
    <div class="col-md-6 offset-md-3">
        <h3 class="text-center" style="padding-top: 2em;">Details Of {{ $student->id_no }}</h3>
        <table class="table">
            <tr>
                <td>Name</td>
                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
            </tr>
            <tr>
                <td>Father's Name</td>
                <td>{{ $student->father_name }}</td>
            </tr>
            <tr>
                <td>Mother's Name</td>
                <td>{{ $student->mother_name }}</td>
            </tr>
            <tr>
                <td>Registration Number</td>
                <td>{{ $student->registration_no }}</td>
            </tr>
            <tr>
                <td>Session</td>
                <td>{{ $student->session }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $student->email }}</td>
            </tr>
            <tr>
                <td>Faculty</td>
                <td>{{ $student->faculty->faculty_name }}</td>
            </tr>
            <tr>
                <td>Hall</td>
                <td>{{ $student->hall->hall_name }}</td>
            </tr>
            <tr>
                <td>Hal Allotment ID</td>
                <td>{{ $student->hall_alot_id }}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{ $student->full_address }}</td>
            </tr>
            <tr>
                <td>City</td>
                <td>{{ $student->city }}</td>
            </tr>
            <tr>
                <td></td>
                <td> <a type="button" class="btn btn-primary float-right" href="{{ route('admin.studentlist',$student->session) }}">Back</a></td>
            </tr>
        </table>
</div>
@endsection
