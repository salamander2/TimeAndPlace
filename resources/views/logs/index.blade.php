@extends('layouts.app')




@section('content')

{{--  <ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	<li class="active"> Kiosks List</li>
</ol>  --}}


<div class="container">
    <h1>Logs for {{ $kiosk->name }} </h1>
    
    @foreach ($logs as $log)
        @php 
            $studentID = $log-> studentID;
            $student = \App\Student::find($studentID);
        @endphp
        <div class="row align-middle">
            
            <div class="col-md-3">
                <p>{{ $studentID }}</p>
            </div>
            <div class="col-md-3">
                <p>{{ $student->lastname . ', ' . $student->firstname}}</p>
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
