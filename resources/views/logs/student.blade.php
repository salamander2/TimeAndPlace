@extends('layouts.app')


@section('content')

{{--  <ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	<li class="active"> Kiosks List</li>
</ol>  --}}



<div class="container">
<div class="card-body">
<div class="row ">
<div class="col-md-2"> <button class="btn btn-outline-danger">Today</button> </div>
<div class="col-md-2"> <button class="btn btn-outline-warning">Yesterday</button> </div>
<div class="col-md-2"> <button class="btn btn-outline-success">This Week</button> </div>
<div class="col-md-2"> <button class="btn btn-outline-info">This Month</button> </div>
<div class="col-md-2"> <button class="btn btn-outline-primary">Last Month</button> </div>
<div class="col-md-2"> <button class="btn btn-secondary">All</button> </div>
</div>

</div>
    <h1>Logs for {{ $student->lastname . ', ' . $student->firstname }} </h1>
    <h2>Today's logs</h2> '
    <h2>All logs</h2>
    @foreach ($logs as $log)
        @php
            $kiosk = \App\Kiosk::find($log->kiosk_id);
        @endphp
        <div class="row align-middle">
            
            <div class="col-md-3">
              {{ $kiosk->name }}
            </div>
            
            <div class="col-md-3">                   
                <p>{{ $log-> status_code }}</p>
            </div>
            <div class="col-md-3">                   
                    <p>{{ $log-> updated_at }}</p>
                </div>
            
        </div>
    @endforeach
    
</div>
@endsection
