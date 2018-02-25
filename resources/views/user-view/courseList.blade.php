@extends('layouts.app')

@section('content')
<div class="container">

  <div class="row" style="padding-top: 3em;">
    <div class="col-md-8 offset-md-2 text-center">
        <h1>Course List</h1>
    	<table class="table">
    		<thead>
    			<th>Course Code</th>
    			<th>Course Title</th>
          <th>Course Credit</th>
    		</thead>
    		<tbody>
    			@foreach($courses as $course)
    			<tr>
    				<td>{{ $course->course_id }}</td>
    				<td>{{ $course->course_title }}</td>
            <td>{{ $course->credit }}</td>
    			</tr>
    			@endforeach
    		</tbody>
    	</table>
    </div>
  </div>

</div>
@endsection
