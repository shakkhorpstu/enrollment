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

  @if(Session::has('success'))

    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>

@endif

<!-- <div class="form-group">
    <button @click="addFI" type="button" class="btn btn-danger" style="float:right;">Add FI</button>
</div> -->

<form method="POST" action="{{ route('submit.enrollform') }}" class="form-horizontal" role="form">

  {{ csrf_field() }}
  <h2 class="text-center text-success">Level-{{ $level }} Semester-{{ $semester }} Regular Course Details</h2>
  <input type="hidden" value="{{$semester}}" name="semester">
  <input type="hidden" value="{{$level}}" name="level">
  @if(!empty($regular_courses))
  <table class="table">
    <thead>
      <th class="text-center">Course Code</th>
      <th class="text-center">Course Title</th>
      <th class="text-center">Course Credit</th>
      <th class="text-center">Credit Value</th>
    </thead>
    <tbody>
      @foreach($regular_courses as $regular_course)
      <tr>
        <td class="text-center">{{ $regular_course->course_id }}</td>
        <input type="hidden" value="{{$regular_course->course_id}}" name="regular_course_id[]">
        <td class="text-center">{{ $regular_course->course_title }}</td>
        <td class="text-center">{{ $regular_course->credit }}</td>
        <input type="hidden" value="{{ $regular_course->credit }}" name="regular_credit[]">
        @php
          $per_credit_value = 75;
          $credit_value = $regular_course->credit * $per_credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }} TK</td>
      </tr>
      @endforeach
      <tr class="text-success">
        <td></td>
        <td></td>
        <td class="text-center"><h3>Total</h3></td>
        <td class="text-center"><h3>{{ $total_regular_amount }} TK</h3></td>
        <input type="hidden" value="{{$total_regular_amount}}" name="total_amount">
      </tr>
    </tbody>
  </table>
  @else
  <h3 class="text-center text-warning" style="padding-top: 1em;">You Have Already Enrolled To This Semester</h3>
  @endif

  <!-- There will set a if condition for checking if there is any empty repeat_field or not -->
  <h2 class="text-danger text-center">Repeat Course Details</h2>
  <table class="table">
    <thead>
      <th class="text-center">Course Code</th>
      <th class="text-center">Course Title</th>
      <th class="text-center">Course Credit</th>
      <th class="text-center">Credit Value</th>
    </thead>
    <tbody>
      @foreach($repeat_courses_one as $repeat_course_one)
      <tr>
        <td class="text-center">{{ $repeat_course_one }} </td>
        <input type="hidden" value="{{$repeat_course_one}}" name="repeat_course_one[]">
        @php
        $repeat_one = DB::table('courses')
        ->where('course_id', $repeat_course_one)
        ->first();
        @endphp
        <td class="text-center">{{ $repeat_one->course_title }}</td>
        <td class="text-center">{{ $repeat_one->credit }}</td>
        <input type="hidden" value="{{$repeat_one->credit}}" name="repeat_credit_one[]">
        @php
          $per_credit_value = 75;
          $credit_value = $repeat_one->credit * $per_credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }}</td>
      </tr>
      @endforeach

      @foreach($repeat_courses_two as $repeat_course_two)
      <tr>
        <td class="text-center">{{ $repeat_course_two }} </td>
        <input type="hidden" value="{{$repeat_course_two}}" name="repeat_course_two[]">
        @php
        $repeat_two = DB::table('courses')
        ->where('course_id', $repeat_course_two)
        ->first();
        @endphp
        <td class="text-center">{{ $repeat_two->course_title }}</td>
        <td class="text-center">{{ $repeat_two->credit }}</td>
        <input type="hidden" value="{{$repeat_two->credit}}" name="repeat_credit_two[]">
        @php
          $per_credit_value = 75;
          $credit_value = $repeat_two->credit * $per_credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }}</td>
      </tr>
      @endforeach

      @foreach($repeat_courses_three as $repeat_course_three)
      <tr>
        <td class="text-center">{{ $repeat_course_three }} </td>
        <input type="hidden" value="{{$repeat_course_three}}" name="repeat_course_three[]">
        @php
        $repeat_three = DB::table('courses')
        ->where('course_id', $repeat_course_three)
        ->first();
        @endphp
        <td class="text-center">{{ $repeat_three->course_title }}</td>
        <td class="text-center">{{ $repeat_three->credit }}</td>
        <input type="hidden" value="{{$repeat_three->credit}}" name="repeat_credit_three[]">
        @php
          $per_credit_value = 75;
          $credit_value = $repeat_three->credit * $per_credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }}</td>
      </tr>
      @endforeach

      <tr class="text-danger">
        <td></td>
        <td></td>
        <td class="text-center"><h3>Total</h3></td>
        <td class="text-center"><h3>{{ $total_repeat_amount }} TK</h3></td>
        <input type="hidden" value="{{$total_repeat_amount}}" name="total_repeat_amount">
      </tr>
      <tr>
        <td></td>
        <td class="text-center"><h1>Total</h1></td>
        <td></td>
        <td class="text-center"><h1>{{ $total_amount }} TK</h1></td>
        <input type="hidden" value="{{$total_amount}}" name="total_amount">
      </tr>
      <tr>
    </tbody>
  </table>

  <div class="form-group">
    <label><h4><strong>Residential Hall</strong></h4></label>
    <input type="text" class="form-control" value="{{ $hall->hall_name }}" disabled/>
    <input type="hidden" name="hall_id" class="form-control" value="{{ $hall->id }}"/>
  </div>

  <div class="form-group">
    <label><h4><strong>Allotment ID</strong></h4></label>
    <input type="text" class="form-control" value="{{ Auth::User()->hall_alot_id }}" disabled/>
    <input type="hidden" name="hall_allot_id" class="form-control" value="{{ Auth::User()->hall_alot_id }}"/>
  </div>

  {{-- <div class="form-group">
    <!-- <label><h4><strong>Transaction ID</strong></h4></label> -->
    <input type="hidden" name="transaction_id" class="form-control" placeholder="Transaction ID"/>
  </div>
  <div class="form-group">
    <!-- <label><h4><strong>Phone Number</strong></h4></label> -->
    <input type="hidden" name="phone_number" class="form-control" placeholder="Phone Number"/>
  </div> --}}
  <div class="form-group">
    <button class="btn btn-success" style="float: right;">Enroll To Semester {{ $semester }}</button>
  </div>


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
    fi_name :[],
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
