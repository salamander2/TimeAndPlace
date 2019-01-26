@extends('layouts.app')
<ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a> </li>
	<li class="active"> Users</li>
</ol>



@section('content')
<div class="container">
	<h1>		
		All Kiosks
	</h1>

    <ul>
        @foreach ($kiosks as $kiosk)
        <li>
           <a href="/kiosks/{{ $kiosk->id }}/edit"> {{ $kiosk-> name }} ... {{ $kiosk-> room }} </a>
        </li>
        @endforeach
    </ul>
            <a href="/addKiosk">Create a new Kisok</a>
</div>
@endsection
