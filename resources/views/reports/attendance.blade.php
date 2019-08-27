@extends('layouts.app')

{{--  view to display all attendance (PRESENT) for one particular student kiosk, for CURRENT MONTH ONLY  --}}
@section('content')



<div class="container">
 {{-- <div class="card"> REMOVE so that there is no border --}}
    <div class="card-header">    
    <div class="card-header">
        <div class="row">
            <div class="col-md-2"><form action="{{'/reports/'.$kiosk->id}}/M" method="get">
                <button id="btnT" type="submit" class="btn btn-outline-success">This Month</button> </form></div>
            <div class="col-md-2"><form action="{{'/reports/'.$kiosk->id}}/P" method="get">
                <button id="btnY" class="btn btn-outline-primary">Last Month</button> </form></div>
            <div class="col-md-2"><form action="{{'/reports/'.$kiosk->id}}/A" method="get">
                <button id="btnA" class="btn btn-secondary">All</button> </form></div>
        </div>
    </div>
        <div class="card-title">                
                <h2>
                @if ($code == 'A')
                    All attendance for {{ $kiosk->name }}
                @else
                    Monthly attendance for {{ $kiosk->name }}
                @endif
                </h2>                
        </div>
    </div>
    
    
    <div class="card-body">
        <table class="table table-bordered text-center thead-dark table-striped">
        @foreach ($array as $arr) 
            @if ($loop->first)  {{-- OR foreach($array as $key => $value)      if($key == 0) --}}
                <tr class="bg-success">
            @else
                <tr>
            @endif
            
            @foreach ($arr as $index=>$value) 
	    {{-- testing different formating for first/last column , but top row is still original formatting --}}
            @if ($loop->first && $loop->parent->index > 0)
                <th class="bg-info">
            @elseif ($code == 'A' && $loop->index == 1 && $loop->parent->index > 0)
                <th class="bg-warning">
            @else
               <th>
            @endif
                {{ $value }}
            </th>
            @endforeach
        </tr>
        @endforeach
        </Table>
		<h6><br> {{ count($array) -1 }} students </h6>
    {{-- </div>     --}}

</div>
@endsection
