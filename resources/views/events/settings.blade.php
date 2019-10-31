@extends('layouts.app') 
@section('content')
{{--<a href="{{'/kiosks/'.$kiosk->id.'/edit' }}" class="btn btn-outline-secondary small">Back</a>  --}}

@if (session('error'))
<div class="alert alert-error" role="alert">
    {{ session('error') }}
    <br>
    <p class="small">Change this to a popup message that then disappears</p>
</div>
@endif

<div class="container">
    <h1>
       Options for event: {{$event->name}} 
    </h1>
    
    

    <div class="card xxbg-info">
        <div class="card-body">
            
            <div class="row">
                <div class="col">
                    <a target="_blank" href="{{'/events/terminal/'.$event->id}}"><button type="button" class="elevation-3 btn btn-warning">Start Login Terminal</button></a>
                </div><div class="col">
                    <a href="{{'/events/report/'.$event->id}}"><button type="button" class="elevation-3 btn btn-success">Late / Absent Report</button></a>
                </div><div class="col">
                    <a href="{{'/events/reportPrint/'.$event->id}}"><button type="button" class="elevation-3 btn btn-outline-success">Printable Report</button></a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-dark ">
            <div class="card-header" data-widget="collapse">
                <h3 class="card-title">Create Attendance List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" xxdata-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
                </div>
            </div>
        <div class="card-body">
            <div class="btn btn-outline-danger"> FIX THIS: You should not be able to modify the attendance for an event that is already in the past</div>
            <h4>Enter a course code to add all students in that course & section to the attendance list for this event.</h4>
                <p>No spaces, No hyphen. e.g. ATC10102</p>
            <form role="form" action="/events/addStudents" method="post">                                        
                <input type="hidden" id="eventID" name="eventID" value="{{$event->id}}">
                {{csrf_field()}}
                <div class="form-group">                   
                        <div class="input-group">
                            {{--  <a href="#" data-toggle="tooltip" title="" data-original-title="Default tooltip">you probably</a>  --}}
                            <div class="input-group-prepend btn btn-outline-success" for="name">Course code:</div>
                            <input type="text" class="form-control mx-1 col-2 border border-success" id="courseCode" name="courseCode" required autofocus>
                            <button type="submit" class="btn col-1 btn-primary  elevation-3">Submit</button>
                        </div>          
                </div>
            </form>
        </div>

        <div class="card-body">
            <h4>Add a student by student number</h4>
            <p>*** This is not working yet</p>
            <div class="form-group">                   
                    <div class="input-group">
                        {{--  <a href="#" data-toggle="tooltip" title="" data-original-title="Default tooltip">you probably</a>  --}}
                        <div class="input-group-prepend btn btn-outline-success" for="name">Student number:</div>
                        <input type="text" class="form-control mx-1 col-2 border border-success" id="courseCode" name="courseCode" required autofocus>
                        <button type="submit" class="btn col-1 btn-primary  elevation-3">Submit</button>
                    </div>          
            </div>
        </div>
        <div class="card-body">
        <h4>Copy student list from another event to this one :</h4>
        <form role="form" action="/events/copyStudentList" method="post">                
            {{csrf_field()}}
                <input type="hidden" id="eventID" name="eventID" value="{{$event->id}}">
                <span class="alert btn-outline-success" for="sourceID"><b>From which event?</b></span>(enter event number)
                <input type="text" class="col-1"  id="sourceID" name="sourceID" required autofocus>                    
                <button type="submit" class="btn btn-primary elevation-3">Submit</button>                
                
        </form>
        </div>
    </div>

    <div class="card card-dark">
        <div class="card-header" data-widget="collapse">
                <h3 class="card-title">Attendance List for this Event</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" xxdata-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
                </div>
            </div>
        <div class="card-body">
            @if($studentList->count())
                <h5>Students attached to this event</h5>
                
                <p>Click on check boxes to remove student<br>
                    *** This is not yet implmenented</p>
                <hr>
                <table cellspacing=0 cellpadding=5 class="table-hover table-striped">
                <tr><th>Student Num</th><th>Name</th><th>Remove</th></tr>
                @foreach($studentList as $SL)
                    <tr>
                        <td>{{$SL->student_id}} </td>
                        <td>{{$SL->student['lastname']}}, {{$SL->student['firstname']}} </td> {{-- not $SL->student->lastname --}}
                        <td><input type="checkbox"></td>
                    </tr>
                @endforeach 
                </table>
            @else
            <h5>No students have been attached to this event yet</h5>
            @endif
        </div>
    </div>
</div>
@endsection
