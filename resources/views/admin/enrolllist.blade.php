@extends('layouts.admin_app')

@section('content')
<div class="container">
<div class="row" style="padding-top: 1em;">
        <div class="col-md-12" >
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
                    <form class="form-group form-inline" action="{{ route('admin.search.uncompleteEnroll') }}" method="post">
                        {{ csrf_field() }}
                    <input type="text" name="search" class="form-control float-right" placeholder="Search ID">
                    <input type="hidden" name="level" value="{{ $level }}" class="form-control">
                    <input type="hidden" name="semester" value="{{ $semester }}" class="form-control">
                    <button class="btn btn-success float-right" style="margin-left: .2em;">Search</button>
                </form>
            </div>

            @elseif($confirm == 1)
            <div class="form-group col-md-4 offset-md-8" style="padding-top: 1em;">
                    <form class="form-group form-inline" action="{{ route('admin.search.completeEnroll') }}" method="post">
                        {{ csrf_field() }}
                    <input type="text" name="search" class="form-control float-right" placeholder="Search ID">
                    <input type="hidden" name="level" value="{{ $level }}" class="form-control">
                    <input type="hidden" name="semester" value="{{ $semester }}" class="form-control">
                    <button class="btn btn-success float-right" style="margin-left: .2em;">Search</button>
                </form>
            </div>
            @endif

            <h2 class="text-center">Enrolled Information</h2>

                <table class="table">
                    <thead class="bg-dark" style="color: #ffffff;">
                        <th>#</th>
                        <th>Name</th>
                        <th>ID</th>
                        <th>Total</th>
                        <th>Hall Pay</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @php $i = 1;
                        @endphp
                        @foreach($enrolls as $enroll)
                        <tr>
                            <td>@php echo $i++ @endphp</td>
                            <td>{{ $enroll->name }}</td>
                            <td>{{ $enroll->id_no }}</td>
                            <td>{{ $enroll->amount }}</td>
                            @if($enroll->hall_pay_status)
                            <td>{{ "Paid" }}</td>
                            @else
                            <td>{{ "Unpaid" }}</td>
                            @endif
                            <td>
                            @if($enroll->hall_pay_status)
                                @if($enroll->confirm == 0)   
                                {{ Form::open(['route' => ['admin.enroll.mail',$enroll->id_no],'method' => 'POST']) }}
                                {{ Form::submit('Confirm',['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                @else
                                {{ Form::open(['route' => ['admin.enroll.unconfirm',$enroll->id_no],'method' => 'POST']) }}
                                {{ Form::submit('Unconfirm',['class' => 'btn btn-primary']) }}
                                {{ Form::close() }}
                                @endif
                            @else
                            <button class="btn btn-danger" disabled>Confirm</button>
                            @endif 
                            </td>
                            <td>
                            @if($enroll->confirm == 1)
                                {{ Form::open(['route' => ['admin.enroll.completedRepeat',$enroll->id_no],'method' => 'POST']) }}
                                <input type="hidden" name="level" value="{{ $enroll->level }}"/>
                                <input type="hidden" name="semester" value="{{ $enroll->semester }}"/>
                                {{ Form::submit('Repeat Course',['class' => 'btn btn-warning']) }}
                                {{ Form::close() }}
                            @else
                            {{ Form::open(['route' => ['admin.enroll.repeat',$enroll->id_no],'method' => 'POST']) }}
                                <input type="hidden" name="level" value="{{ $enroll->level }}"/>
                                <input type="hidden" name="semester" value="{{ $enroll->semester }}"/>
                                {{ Form::submit('Repeat Course',['class' => 'btn btn-warning']) }}
                                {{ Form::close() }}
                            @endif
                            </td>
                            <td>
                            {{ Form::open(['route' => ['admin.enroll.delete',$enroll->id],'method' => 'DELETE']) }}
                            {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
    </div>
</div>
</div>
@endsection
