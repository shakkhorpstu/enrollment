@extends('layouts.app')

@section('content')
<div class="container">
<div id="form_number">
  <div class="row" style="padding-top: 2em;">
<div class="col-md-8 offset-md-2">

  @if ($errors->any())
    @foreach ($errors->all() as $error)
      <p class="text-danger">{{ $error }}</p>
      @endforeach
  @endif

  @if(Session::has('danger'))

    <div class="alert alert-danger" role="alert">
        {{ Session::get('danger') }}
    </div>

@endif

<!-- <div class="form-group">
    <button @click="addFI" type="button" class="btn btn-danger" style="float:right;">Add Repeat Course</button>
</div> -->

<form method="POST" action="{{ route('enrollform.details') }}" class="form-horizontal" role="form">

  {{ csrf_field() }}

  @php
    $toal_repeat_amount = 0;
    $i = 0;
  @endphp

  <h1 class="text-success text-center">Level-{{ $level }} Semester-{{ $semester }} Regular Course Details</h1>
  <input type="hidden" value="{{$semester}}" name="semester">
  <input type="hidden" value="{{$level}}" name="level">
  <table class="table">
    <thead>
      <th class="text-center">Course Code</th>
      <th class="text-center">Course Title</th>
      <th class="text-center">Course Credit</th>
      <th class="text-center">Credit Value</th>
    </thead>
    <tbody>
      @foreach($courses as $regular_course)
      <tr>
        <td class="text-center">{{ $regular_course->course_id }}</td>
        <input type="hidden" value="{{$regular_course->course_id}}" name="regular_course_id[{{$i}}]">
        <td class="text-center">{{ $regular_course->course_title }}</td>
        <td class="text-center">{{ $regular_course->credit }}</td>
        @php
          $per_credit_value = 75;
          $credit_value = $regular_course->credit * $per_credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }} TK</td>
      </tr>
      @php
        $i++;
      @endphp
      @endforeach
      <tr class="text-success">
        <td></td>
        <td></td>
        <td class="text-center"><h3>Total</h3></td>
        <td class="text-center"><h3>{{ $total_amount }} TK</h3></td>
        <input type="hidden" value="{{$total_amount}}" name="total_amount">
      </tr>
    </tbody>
  </table>

  <h2 class="text-danger text-center"><strong>Please Confirm Your Repeat Courses</strong></h2>
  <table class="table">
    <thead>
      <th class="text-center">Course Code</th>
      <th class="text-center">Course Title</th>
      <th class="text-center">Course Credit</th>
      <th class="text-center">Credit Value</th>
    </thead>
    <tbody>
      @php
      $index = 0;
      @endphp
      @foreach($repeatcoursesone as $repeatcourseone)
      <tr>
        <td class="text-center">{{ $repeatcourseone->course_id }}</td>
        <input type="hidden" value="{{$repeatcourseone->course_id}}" name="repeat_course_one[]">
        @php
        $repeat_one = DB::table('courses')
        ->where('course_id', $repeatcourseone->course_id)
        ->first();
        @endphp
        <td class="text-center">{{ $repeat_one->course_title }}</td>
        <td class="text-center">{{ $repeat_one->credit }}</td>
        @php
          $per_credit_value = 75;
          $credit_value = $repeat_one->credit * $per_credit_value;
          $toal_repeat_amount = $toal_repeat_amount + $credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }}</td>
        <td class="form-group"><input type="checkbox" class="checkbox" name="remove_repeat_course_one[]"
           value="{{ $repeatcourseone->course_id }}"
          checked style="width: 1em;"/></td>
      </tr>
      @php
        $index++;
      @endphp
      @endforeach

      @foreach($repeatcoursestwo as $repeatcoursetwo)
      <tr>
        <td class="text-center">{{ $repeatcoursetwo->course_id }}</td>
        <input type="hidden" value="{{$repeatcoursetwo->course_id}}" name="repeat_course_two[]">
        @php
        $repeat_two = DB::table('courses')
        ->where('course_id', $repeatcoursetwo->course_id)
        ->first();
        @endphp
        <td class="text-center">{{ $repeat_two->course_title }}</td>
        <td class="text-center">{{ $repeat_two->credit }}</td>
        @php
          $per_credit_value = 75;
          $credit_value = $repeat_two->credit * $per_credit_value;
          $toal_repeat_amount = $toal_repeat_amount + $credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }}</td>
        <td class="form-group"><input type="checkbox" class="checkbox" name="remove_repeat_course_two[]"
          value="{{ $repeatcoursetwo->course_id }}"
          checked style="width: 1em;"/></td>
      </tr>
      @endforeach

      @foreach($repeatcoursesthree as $repeatcoursethree)
      <tr>
        <td class="text-center">{{ $repeatcoursethree->course_id }}</td>
        <input type="hidden" value="{{$repeatcoursethree->course_id}}" name="repeat_course_three[]">
        @php
        $repeat_three = DB::table('courses')
        ->where('course_id', $repeatcoursethree->course_id)
        ->first();
        @endphp
        <td class="text-center">{{ $repeat_three->course_title }}</td>
        <td class="text-center">{{ $repeat_three->credit }}</td>
        @php
          $per_credit_value = 75;
          $credit_value = $repeat_three->credit * $per_credit_value;
          $toal_repeat_amount = $toal_repeat_amount + $credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }}</td>
        <td class="form-group"><input type="checkbox" class="checkbox" name="remove_repeat_course_three[]"
          value="{{ $repeatcoursethree->course_id }}"
          checked style="width: 1em;"/></td>
      </tr>
      @endforeach

      <tr class="text-danger">
        <td></td>
        <td></td>
        <td class="text-center"><h3>Total</h3></td>
        <td class="text-center"><h3>{{ $toal_repeat_amount }} TK</h3></td>
        <input type="hidden" value="{{$toal_repeat_amount}}" name="total_repeat_amount">
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><button class="btn btn-info btn-block" style="float: right;">Final Check</button></td>
      </tr>
    </tbody>
  </table>

</form>
<!-- <button @click="addFI" type="button">Add Another FI</button> -->
</div>
</div>
</div>
</div>

<!-- @section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
new Vue({
  el: '#app',
  data: {
    fi_name :{
      course_id: ''
    }
  },
  methods: {
    addFI: function(){
      //alert('message?: DOMString');
      var moreFI = document.getElementById('moreFI');
      var elementInside = document.createElement("div");
      var label = elementInside.innerHTML = "Add FI Course";
      moreFI.append(label);
      elementInside.innerHTML = '<input name="fi_name[]" v-model="fi_name[]" class="form-control" placeholder="Add FI"/>';
      moreFI.append(elementInside);
    }
  }
});
</script>
@endsection -->
@endsection
