@extends('layouts.app') 
@section('content')
<a href="{{ url()->previous() }}" class="btn btn-outline-secondary small">Back</a>
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


        <form role="form" action="/events/copyStudentList" method="post">                
            {{csrf_field()}}
                <input type="hidden" id="eventID" name="eventID" value="{{$event->id}}">
                
                    <p>Copy student list from another event to this one :
                    <span class="alert btn-outline-success" for="sourceID"><b>From which event?</b></span> 
                    <input type="text" class="col-1"  id="sourceID" name="sourceID" required autofocus>                    
                    <button type="submit" class="btn btn-info">Go</button>                
                
        </form>
        </div>
    </div>

    <div class="card xxbg-info">
        <div class="card-body">
            
            
            <p><a target="_blank" href="{{'/events/terminal/'.$event->id}}"><button type="button" class="btn btn-warning">Start Login Terminal</button></a></p>
            <p><a href="{{'/events/report/'.$event->id}}"><button type="button" class="btn btn-success">Report: late/absent</button></a></p>
        </div>
    </div>
@endsection
