@extends('layouts.app')

{{--  view to display all attendance for one particular event: Status is P(resent), L(ate), A(bsent), or -(absent)  --}}
@section('content')


<div class="container">
 <div class="card">
    <div class="card-header">    
        <div class="card-title">                
                <h2>
                    Attendance for {{ $event->name }}
                
                <div class="float-right"> <a href="{{'/events/reportPrint/'.$event->id}}"><button type="button" class="btn btn-outline-info">Printable Report</button></a></p></div>
            </h2>                
            <h6 class="text-secondary">When tracking attendance as students sign in, please remember to refresh this page.</h6>
        </div>
        
    </div>
    
    
    <div class="card-body">
    <div class="row">
    <div class="col-md-6">
        <table class="table table-bordered thead-dark table-striped">
            <tr class="bg-info text-center"><th>Student Name</th><th>Time Signed in</th></tr>
        @foreach ($array as $arr) 
            @if($arr[1] == 'A' || $arr[1] == '-') 
            <tr class="bg-danger">
            @elseif ($arr[1] == 'L')
            <tr class="bg-warning">
            @elseif ($arr[1] == 'P')
            <tr class="bg-success">
            @else
            <tr>
            @endif
                        
            <td>{{$arr[0]}}</td>
            <td>{{$arr[2]}}</td>
            
        </tr>
        @endforeach
        </Table>
        <h6><br> {{ count($array)}} students </h6>
    </div>
    </div>
    </div>    

</div>
@endsection
