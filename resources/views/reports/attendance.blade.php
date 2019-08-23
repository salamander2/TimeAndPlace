@extends('layouts.app')

{{--  view to display all attendance (PRESENT) for one particular student kiosk, for CURRENT MONTH ONLY  --}}
@section('content')



<div class="container">
 <div class="card">
    <div class="card-header">    
        <div class="card-title">                
                <h2>
                    Monthly attendance for {{ $kiosk->name }}
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
    </div>    

</div>
@endsection
