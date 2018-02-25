<!-- No use of this file -->

@extends('layouts.app')

@section('content')
<div class="container">
<div id="form_number">
  <div class="row" style="padding-top: 2em;">
<div class="col-md-8 offset-md-2">

  <!-- @if ($errors->any())
    @foreach ($errors->all() as $error)
      <p class="text-danger">{{ $error }}</p>
      @endforeach
  @endif

  @if(Session::has('success'))

    <div class="alert alert-success" role="alert">
        <strong>Success:</strong> {{ Session::get('success') }}
    </div>

 @endif -->

<!-- <div class="form-group">
    <button @click="addFI" type="button" class="btn btn-danger" style="float:right;">Add FI</button>
</div> -->

<form method="POST" action="{{ route('enrollform.repeat') }}" class="form-horizontal" role="form" style="padding-top: 1em;">
  {{ csrf_field() }}
  <h2 class="text-center text-success">Semester {{ $semester }} Course Details</h2>
  <input type="hidden" value="{{$semester}}" name="semester">
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
        <input type="hidden" value="{{$regular_course->course_id}}" name="regular_course_id[]">
        <td class="text-center">{{ $regular_course->course_title }}</td>
        <td class="text-center">{{ $regular_course->credit }}</td>
        @php
          $per_credit_value = 75;
          $credit_value = $regular_course->credit * $per_credit_value;
        @endphp
        <td class="text-center">{{ $credit_value }} TK</td>
      </tr>
      @endforeach
      <tr class="text-success">
        <td class="text-center"></td>
        <td class="text-center"></td>
        <td class="text-center"><h3>Total</h3></td>
        <td class="text-center"><h3>{{ $total_amount }} TK</h3></td>
        <input type="hidden" value="{{$total_amount}}" name="total_amount">
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td><button class="btn btn-info btn-block" style="float: right;">Check Next</button></td>
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
