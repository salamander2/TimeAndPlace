@extends('layouts.app')

{{--  view to display all logs for one particular student and by date or kiosk  --}}
@section('content')

{{--  <ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	<li class="active"> Kiosks List</li>
</ol>  --}}



<div class="container">
{{--  <div class="card">      --}}
    
    <div class="card-body">
        <h1>Logs for {{ $student->lastname }}, {{$student->firstname}} : {{ $student->studentID }}</h1>
    <hr>        

 <div class="col-md-2 alert alert-danger">Today</div>
{{--                     
            
           
           
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/P" method="get">
                <button id="btnP" class="btn btn-outline-primary">Last Month</button> </form></div>
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/A" method="get">
                <button id="btnA" class="btn btn-secondary">All</button> </form></div> --}}
	
        @foreach ($todaylogs as $log)
            <div class="row align-middle">
                
                <div class="col-md-3">
                    <p>{{ $log->kiosk->name }} </p>
                </div>
                <div class="col-md-3">                   
                    <p>{{ $log-> status_code }}</p>
                </div>
                <div class="col-md-3">                   
                        <p>{{ $log-> updated_at }}</p>
                    </div>
            </div>
        @endforeach

        <div class="col-md-2 alert alert-warning">Yesterday</div>
        @foreach ($yesterlogs as $log)
            <div class="row align-middle">
                <div class="col-md-3">
                    <p>{{ $log->kiosk->name }} </p>
                </div>
                <div class="col-md-3">                   
                    <p>{{ $log-> status_code }}</p>
                </div>
                <div class="col-md-3">                   
                        <p>{{ $log-> updated_at }}</p>
                    </div>
            </div>
        @endforeach


        <div class="col-md-2 alert alert-success">This Week</div>
        @foreach ($weeklogs as $log)
            <div class="row align-middle">
                <div class="col-md-3">
                    <p>{{ $log->kiosk->name }} </p>
                </div>
                <div class="col-md-3">                   
                    <p>{{ $log-> status_code }}</p>
                </div>
                <div class="col-md-3">                   
                        <p>{{ $log-> updated_at }}</p>
                    </div>
            </div>
        @endforeach
    
        <div class="col-md-2 alert alert-info">This Month</div>
            @foreach ($monthlogs as $log)
                <div class="row align-middle">
                    <div class="col-md-3">
                        <p>{{ $log->kiosk->name }} </p>
                    </div>
                    <div class="col-md-3">                   
                        <p>{{ $log-> status_code }}</p>
                    </div>
                    <div class="col-md-3">                   
                            <p>{{ $log-> updated_at }}</p>
                        </div>
                </div>
            @endforeach

            <div class="col-md-2 alert alert-primary">Last Month</div>
            @foreach ($prevmonthlogs as $log)
                <div class="row align-middle">
                    <div class="col-md-3">
                        <p>{{ $log->kiosk->name }} </p> 
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
{{--  </div>      --}}
</div>
@endsection
