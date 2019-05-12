@extends('layouts.app')

{{--  view to display all attendance (PRESENT) for one particular student kiosk, for CURRENT MONTH ONLY  --}}
@section('content')



<div class="container">
 <div class="card">
    <div class="card-header">    
        <div class="card-title">                
                <h1>
                    Monthly attendance for {{ $kiosk->name }}
                </h1>                
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
            <th>
                {{ $value }}
            </th>
            @endforeach
        </tr>
        @endforeach
        </Table>
    </div>    

</div>
@endsection
