@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Patuakhali Science & Technology University Enrollment</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>We Cordially Welcome You To Patuakhali Science & Technology University Enrtollment System. Student Of PSTU Can Complete Their Enrollment Through This Web Application</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
