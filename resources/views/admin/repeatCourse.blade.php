@extends('layouts.admin_app')

@section('content')
<div class="container">
<div class="col-md-6 offset-md-3"  style="padding-top: 5em;">
  <h4 class="text-center">Repeat Course For ID- {{ $studentid }}</h4>
      <table class="table">
          <thead class="">
            <th>#</th>
            <th>Course Code</th>
            <th>Level</th>
            <th>Semester</th>
            <th>Credit</th>
          </thead>
          <tbody>
            @php $serial = 1; @endphp
            @foreach($repeatcoursesone as $repeat_courseone)
            <tr>
              <td>@php echo $serial; @endphp</td>
              <td>{{ $repeat_courseone->course_id }}</td>
              <td>{{ $repeat_courseone->level }}</td>
              <td>{{ $repeat_courseone->semester }}</td>
              <td>{{ $repeat_courseone->course_credit }}</td>
            </tr>
            @php $serial++; @endphp
            @endforeach

            @foreach($repeatcoursestwo as $repeat_coursetwo)
            <tr>
              <td>@php echo $serial; @endphp</td>
              <td>{{ $repeat_coursetwo->course_id }}</td>
              <td>{{ $repeat_coursetwo->level }}</td>
              <td>{{ $repeat_coursetwo->semester }}</td>
              <td>{{ $repeat_coursetwo->course_credit }}</td>
            </tr>
            @php $serial++; @endphp
            @endforeach

            @foreach($repeatcoursesthree as $repeat_coursethree)
            <tr>
              <td>@php echo $serial; @endphp</td>
              <td>{{ $repeat_coursethree->course_id }}</td>
              <td>{{ $repeat_coursethree->level }}</td>
              <td>{{ $repeat_coursethree->semester }}</td>
              <td>{{ $repeat_coursethree->course_credit }}</td>
            </tr>
            @php $serial++; @endphp
            @endforeach
          </tbody>
      </table>
</div>
</div>
@endsection
