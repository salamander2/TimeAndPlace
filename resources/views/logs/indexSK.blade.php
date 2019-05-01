@extends('layouts.app')

{{--  view to display all logs for one particular student and by kiosk  --}}
@section('content')

{{--  <ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	<li class="active"> Kiosks List</li>
</ol>  --}}



<div class="container">
{{--  <div class="card">      --}}
    
    <div class="card-body">
        <div class="row">
                <div class="col-auto mr-auto">
                    <h1>
                        Logs for {{ $student->lastname }}, 
                        {{ $student->firstname }} : 
                        {{ $student->studentID }}
                    </h1>
                </div>
                <div class="col-auto alert alert-secondary elevation-3">
                    <a class="text-dark" href="/logs/byStudent/{{ $student->studentID }}">Sort by Date</a>
                </div>
            </div>
    <hr>        

        @php
            $k = -1;
        @endphp
        @foreach ($logs as $log)
            @php
            $knext = $log->kiosk_id;
            @endphp
            @if ($k != $knext)
            
                <div class="col-md-6 alert alert-success"> {{ $log->kiosk->name }}</div>
                @php
                $k = $knext;
                @endphp
            @endif
            
            <div class="row align-middle">
                
                
                <div class="col-md-3">                   
                    <p>{{ $log-> status_code }}</p>
                </div>
                <div class="col-md-3">                   
                        <p>{{ $log-> created_at->format('D d M Y - h:i a') }}</p>
                    </div>
            </div>
        @endforeach

        
    </div>    
{{--  </div>      --}}
</div>
@endsection
