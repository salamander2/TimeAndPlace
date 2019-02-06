@extends('layouts.app')




@section('content')

<ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a> </li>
	<li class="active"> Users</li>
</ol>


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
            <a href="/kiosks/create">Create a new Kisok</a>
</div>
@endsection
