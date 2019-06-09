@extends('layouts.app')

{{--  view to display summary statistics for LOGS for one kiosk  --}}
@section('content')



<div class="container">
 <div class="card">
    <div class="card-header">    
        <div class="card-title">                
                <h2>
                    Statistics for {{ $kiosk->name }}
                </h2>                
        </div>
    </div>
    
    
    <div class="card-body">
        <table class="table table-bordered text-center thead-dark table-striped">
        @foreach ($array as $arr) 
            @if ($loop->first)  {{-- OR foreach($array as $key => $value)      if($key == 0) --}}
                <tr class="bg-primary">
            @elseif ($loop->last)
                <tr class="bg-dark">
            @else
                <tr>
            @endif
            
            @foreach ($arr as $index=>$value) 
            <th>
                {{ $value }}
            </th>
            @endforeach
        </tr>
        @endforeach
        </Table>
        <p></p>
		<p>These statistics count the number of "Sign-ins" for each time period</p>
        <p><b>Unique</b> means that each studentID is only counted once. <br>
            This gives a count of how many different students used this department/kiosk in one particular month.<br>
        <b>All</b> would include someone who signed in twice in the same day (counts as 2), as well as multiple days in the month.<br>
        This gives a better idea of how active or heavily used this department/kiosk is</p>
    </div>    

</div>
@endsection
