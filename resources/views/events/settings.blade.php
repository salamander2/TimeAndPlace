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
		<p>Add button to copy all students from another event to this one</p>
		<p>Add button to launch login screen</p>
		<p>Add button to show report of present / late / absent</p>
	</div>
    </div>
@endsection
