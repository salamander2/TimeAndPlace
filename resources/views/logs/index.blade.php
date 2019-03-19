@extends('layouts.app')


<script type="text/javascript">
    $(document).ready(function(){
        alert("hi");
    });
</script>

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
<div class="col-md-2"> <button class="btn btn-outline-secondary">All</button> </div>
</div>

</div>
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
