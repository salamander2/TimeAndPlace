@extends('layouts.app')

{{--  view to display all attendance (PRESENT) for one particular student kiosk, for CURRENT MONTH ONLY  --}}
@section('content')



<div class="container">
 {{-- <div class="card"> REMOVE so that there is no border --}}
    <div class="card-header">
        <div class="row">
            <div class="col-md-2"><form action="{{'/reports/attend/'.$kiosk->id}}/M" method="get">
                <button id="btnM" type="submit" class="btn btn-outline-info">This Month</button> </form></div>
            <div class="col-md-2"><form action="{{'/reports/attend/'.$kiosk->id}}/P" method="get">
                <button id="btnP" class="btn btn-outline-primary">Last Month</button> </form></div>
            <div class="col-md-2"><form action="{{'/reports/attend/'.$kiosk->id}}/A" method="get">
                <button id="btnA" class="btn btn-secondary">All</button> </form></div>
                
        </div>
    </div>
        <div class="card-title w-100 my-3"> 
                @if ($code == 'A')
                <h2>
                    All attendance for {{ $kiosk->name }}
	            <span class="float-right"> <a href="{{'/reportsPrint/attend/'.$kiosk->id.'/A'}}"><button type="button" class="btn btn-outline-secondary">Printable Report</button></a></span>
                </h2>                
                @else
                <h2>
                    Monthly attendance for {{ $kiosk->name }}
                </h2>                
                @endif
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
