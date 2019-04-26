@extends('layouts.app')

{{--  view to display all logs for one particular student and by date or kiosk  --}}
@section('content')

{{--  <ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	<li class="active"> Kiosks List</li>
</ol>  --}}



<div class="container">
{{--  <div class="card">      --}}
    {{-- <div class="card-header">
        <div class="row">
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/T" method="get">
                <button id="btnT" type="submit" class="btn btn-outline-danger">Today</button> </form></div>
                    
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/Y" method="get">
                <button id="btnY" class="btn btn-outline-warning">Yesterday</button> </form></div>
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/W" method="get">
                <button id="btnW" class="btn btn-outline-success">This Week</button> </form></div>
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/M" method="get">
                <button id="btnM" class="btn btn-outline-info">This Month</button> </form></div>
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/P" method="get">
                <button id="btnP" class="btn btn-outline-primary">Last Month</button> </form></div>
            <div class="col-md-2"><form action="{{'/logs/byKiosk/'.$kiosk->id}}/A" method="get">
                <button id="btnA" class="btn btn-secondary">All</button> </form></div>
        </div>
    </div> --}}
    <div class="card-body">
        <h1>Logs for {{ $student->lastname }} . {{$student->firstname}}</h1>
        
        @foreach ($logs as $log)
            {{-- @php 
                $studentID = $log-> studentID;
                $student = \App\Student::find($studentID);
            @endphp --}}
            <div class="row align-middle">
                
                <div class="col-md-3">
                    <p>{{ $studentID }}</p>
                </div>
                <div class="col-md-3">
                    <p>@if ($student != null)
                        {{ $student->lastname . ', ' . $student->firstname }}
                        @else
                        --missing record--
                        @endif
                    </p>
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
