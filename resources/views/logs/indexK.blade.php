@extends('layouts.app')

{{--  view to display all logs by kiosk and by date range selected  --}}
@section('content')

{{--  <ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	<li class="active"> Kiosks List</li>
</ol>  --}}



<div class="container">
{{--  <div class="card">      --}}
    <div class="card-header">
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
    </div>
    <div class="card-body">
        <h1>Logs for {{ $kiosk->name }}</h1>
        
        @foreach ($logs as $log)
           {{-- @php 
                $studentID = $log-> studentID;
                $student = \App\Student::find($studentID);
                // $student = $log->student();
            @endphp  --}}
		
            <div class="row align-middle">
                
                <div class="col-md-3">
                    <p>{{ $log->studentID }}</p>
                </div>
                <div class="col-md-3">
                    <p>{{-- @if ($student != null) --}}
                        {{ $log->student->lastname . ', ' . $log->student->firstname }}
{{--                        @else
                        --missing record--
                        @endif
--}}                    </p>
                </div>
                <div class="col-md-3">                   
                    <p>{{ $log-> status_code }}</p>
                </div>
                <div class="col-md-3">
                        <p>{{ $log->created_at->format('D d M Y - h:m a') }}</p>
                    </div>
                
            </div>
        @endforeach
    </div>    
{{--  </div>      --}}
</div>
<script>
    var code = '{{$code}}';
    document.getElementById("btnA").classList.remove('btn-secondary');
    document.getElementById("btnA").classList.add('btn-outline-secondary');
    switch(code) {
        case 'T':
            document.getElementById("btnT").classList.remove('btn-outline-danger');
            document.getElementById("btnT").classList.add('btn-danger');
            break;
        case 'Y':
            document.getElementById("btnY").classList.remove('btn-outline-warning');
            document.getElementById("btnY").classList.add('btn-warning');
            break;
        case 'W':
            document.getElementById("btnW").classList.remove('btn-outline-success');
            document.getElementById("btnW").classList.add('btn-success');
            break;
        case 'M':
            document.getElementById("btnM").classList.remove('btn-outline-info');
            document.getElementById("btnM").classList.add('btn-info');
            break;
        case 'P':
            document.getElementById("btnP").classList.remove('btn-outline-primary');
            document.getElementById("btnP").classList.add('btn-primary');
            break;
        default:
            document.getElementById("btnA").classList.remove('btn-outline-secondary');
            document.getElementById("btnA").classList.add('btn-secondary');
        } 
</script>
@endsection
