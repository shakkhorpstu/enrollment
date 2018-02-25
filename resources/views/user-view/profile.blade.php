@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row" style="padding-top: 2em;">
    <div class="col-md-6 offset-md-3">
      <h1 style="padding-bottom: 1em; text-align: center;" class="text-danger">Account Information</h1>
      @if(Session::has('success'))
      <div class="alert alert-success" role="alert">
          {{ Session::get('success') }}
      </div>
      @endif
      <a type="button" class="btn btn-warning float-right bg-primary" href="{{ route('editProfile') }}">Edit Profile</a>
      <table class="table">
        <tbody>
        <tr><td><h4 class="text-dark"><strong>First Name:</strong></h4>  <h4 class="float-right text-success">{{ $student->first_name }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Last Name:</strong></h4>   <h4 class="float-right text-success">{{ $student->last_name }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Father's Name:</strong></h4>   <h4 class="float-right text-success">{{ $student->father_name }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Mother Name:</strong></h4>   <h4 class="float-right text-success">{{ $student->mother_name }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Registration Number:</strong></h4>   <h4 class="float-right text-success">{{ $student->registration_no }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>ID NO:</strong></h4>       <h4 class="float-right text-success">{{ $student->id_no }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Faculty:</strong></h4>       <h4 class="float-right text-success">{{ $faculty->faculty_name }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Session:</strong></h4>       <h4 class="float-right text-success">{{ $student->session }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Email:</strong></h4>       <h4 class="float-right text-success">{{ $student->email }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>Full Address:</strong></h4>   <h4 class="float-right text-success">{{ $student->full_address }}</h4></td> </tr>
        <tr><td><h4 class="text-dark"><strong>City:</strong></h4>        <h4 class="float-right text-success">{{ $student->city }}</h4></td> </tr>
      </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
