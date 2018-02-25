@extends('layouts.admin_app')

@section('content')
<div class="container">
  <div class="col-md-12">
    <div class="row">
        <div class="col-md-12" style="padding-top: 1em;">
            @if(Session::has('success'))

            <!-- <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div> -->
            @elseif(Session::has('delete'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('delete') }}
            </div>
            @endif

            @if($confirm == 0)
                <div class="form-group col-md-4 offset-md-8" style="padding-top: 1em;">
                    <form class="form-group form-inline" action="{{ route('admin.search.unconfirmHall') }}" method="post">
                        {{ csrf_field() }}
                    <input type="text" name="search" class="form-control float-right" placeholder="Search ID">
                    <input type="hidden" name="faculty_id" value="{{ $faculty_id }}" class="form-control">
                    <button class="btn btn-success float-right" style="margin-left: .2em;">Search</button>
                </form>
            </div>

            @elseif($confirm == 1)
            <div class="form-group col-md-4 offset-md-8" style="padding-top: 1em;">
                    <form class="form-group form-inline" action="{{ route('admin.search.confirmHall') }}" method="post">
                        {{ csrf_field() }}
                    <input type="text" name="search" class="form-control float-right" placeholder="Search ID">
                    <input type="hidden" name="faculty_id" value="{{ $faculty_id }}" class="form-control"> 
                    <button class="btn btn-success float-right" style="margin-left: .2em;">Search</button>
                </form>
            </div>
            @endif

            <h2 class="text-center" style="padding-top: 1em;">Hall Payment Information</h2>
                <table class="table">
                    <thead class="bg-dark" style="color: #ffffff;">
                        <th>#</th>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Registration</th>
                        <th>Allotment ID</th>
                        <th>Hall Pay</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @php $i = 1;
                        @endphp
                        @foreach($hallsstudentss as $hallsstudent)
                        <tr>
                            <td>@php echo $i++ @endphp</td>
                            <td>{{ $hallsstudent->name }}</td>
                            <td>{{ $hallsstudent->id_no }}</td>
                            <td>{{ $hallsstudent->reg_no }}</td>
                            <td>{{ $hallsstudent->allot_id }}</td>
                            @if($hallsstudent->payment_status)
                            <td class="bg-success">{{ "Paid" }}</td>
                            @else
                            <td class="bg-danger">{{ "Unpaid" }}</td>
                            @endif
                            <td>
                                @if($hallsstudent->payment_status == 1)
                                <a type="button" class="btn btn-primary" href="{{ route('admin.hallUnpaid',$hallsstudent->id_no) }}">
                                    Unpaid</a>
                                @else
                                <a type="button" class="btn btn-primary" href="{{ route('admin.hallPaid',$hallsstudent->id_no) }}">
                                    Paid</a>
                                @endif
                            </td>
                            <td>
                                @if($hallsstudent->payment_status == 1)
                                {{ Form::open(['route' => ['admin.hallstudent.delete',$hallsstudent->id_no],'method' => 'DELETE']) }}
                                {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                {{ Form::close() }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
  </div>
</div>
</div>
@endsection
