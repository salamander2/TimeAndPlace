@extends('layouts.app') 
@section('content')
<div class="container">
    <h1>
       Adding students to event {{$event->name}} 
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
	    <h3 style="float:right">Event ID={{$event->id}}</h3>

            <p>Enter a course code, no spaces, no hyphen. e.g. ATC10102</p>
            <form role="form" action="/events/addStudents" method="post">                                        
                <input type="hidden" id="eventID" name="eventID" value="{{$event->id}}">
                
                <div class="form-group">
                   
                        <div class="input-group">
                            {{--  <a href="#" data-toggle="tooltip" title="" data-original-title="Default tooltip">you probably</a>  --}}
                            <label class="input-group-prepend btn btn-success" for="name">Course code </label>                            
                            <input type="text" class="form-control mx-1 col-2 border border-success" id="courseCode" name="courseCode" required autofocus>
                        </div>                
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary">Submit</button>
		<p style="float:right">TODO: add in an option to add student by name/student number too</p>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-info">
            <div class="card-body">
    @if($studentList->count())
        <p>Students attached to this event</p>
    
        <p>
    @foreach($studentList as $SL)
        
            {{$SL->student_id}} : <b>{{$SL->student->lastname}},</b> {{$SL->student->firstname}}<br/>        
        
    @endforeach 
        </p>
    @endif

</div>
@endsection
