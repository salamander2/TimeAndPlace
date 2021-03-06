@extends('layouts.app') 
@section('content') 
{{--
	<ol class="breadcrumb">
	    <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	    <li class="active"> Kiosks List</li>
	</ol> 
--}} 

<div class="container">
    <h1>My Kiosks</h1>
  
    @foreach ($my_kiosks as $kiosk)
	    <div class="row align-middle">
			<div class="col-sm-4">
				<a class="btn btn-info elevation-2" href="/kiosks/{{ $kiosk->id }}/showORedit"> {{ $kiosk-> name }} @ {{ $kiosk-> room }} </a>
			</div>
			<div class="col-sm-4">
				@if($kiosk->kioskType != 2)
				<a class="my-1 btn btn-success elevation-2" href="/terminals/{{ $kiosk->id }}"> Launch Terminal </a>
				@endif
			</div>
			<div class="col-sm-4">
				@if($kiosk->kioskType == 0)
				<a class="my-1 btn btn-outline-primary" href="/logs/byKiosk/{{ $kiosk->id }}"> Show logs </a>
				@elseif($kiosk->kioskType == 1)
				<a class="my-1 btn btn-outline-primary" href="/reports/attend/{{ $kiosk->id }}"> Attendance Report </a>
				@else
				<p class="my-1 btn">Enter kiosk to view reports</p>
				@endif
			</div>
        </div>
    @endforeach 

	@if($other_kiosks->count())
		<h1>&nbsp;</h1>
		<h1>All Other Kiosks</h1>
    @endif 

	{{-- @foreach ($kiosks as $kiosk)
		<li>
			<a href="/kiosks/{{ $kiosk->id }}/edit"> {{ $kiosk-> name }} @ {{ $kiosk-> room }} </a> <label>- - - -</label>
			<a href="/terminals/{{ $kiosk->id }}"> Launch Terminal </a>
		</li>
	@endforeach --}} 

	@foreach ($other_kiosks as $kiosk)
		<div class="row align-middle">
			<div class="col">
				<a class="my-1 btn btn-secondary elevation-2" href="/kiosks/{{ $kiosk->id }}/show"> {{ $kiosk-> name }} @ {{ $kiosk-> room }} </a>
			</div>
		</div>
	@endforeach
    
    {{-- Script to test if JQuery is working: it will hide the H1 that you click on
	type=application/javascript is needed otherwise vue.js croaks and stops it from running --}}
    <script type="application/javascript">
        $(document).ready(function(){
          $("h1").click(function(){
//            $(this).hide();
		jqversion = $().jquery;
		alert("jQuery is "+jqversion);
          });
        });
    </script>
	</div>
@endsection
