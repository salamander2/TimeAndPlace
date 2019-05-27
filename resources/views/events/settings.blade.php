@extends('layouts.app') 
@section('content')
<div class="container">
    <h1>
       Options for event: {{$event->name}} 
    </h1>
    
    <div class="card card-primary">
        <div class="card-body">
        @if (session('error'))
        <div class="alert alert-error" role="alert">
            {{ session('error') }}
            <br>
            <p class="small">Change this to a popup message that then disappears</p>
        </div>
        @endif

        </div>
    </div>

    <div class="card xxbg-info">
            <div class="card-body">
		
        <p><a href="{{'/events/settings/'.$event->id}}"><button type="button" class="btn btn-info">Copy student list</button></a> from another event to this one</p>
        <p><a href="{{'/events/terminal/'.$event->id}}"><button type="button" class="btn btn-warning">Start Login Terminal</button></a></p>
        <p><a href="{{'/events/report/'.$event->id}}"><button type="button" class="btn btn-success">Report: late/absent</button></a></p>
	</div>
    </div>
@endsection
