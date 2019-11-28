@extends('layouts.app') 
@section('content')
{{--<a href="{{'/kiosks/'.$kiosk->id.'/edit' }}" class="btn btn-outline-secondary small">Back</a>  --}}

<script>
function removeStudent(studentID){

    myurl='/events/removeStudent/{{$event->id}}/' + studentID;
    window.location.href=myurl;
    /*$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        async: true,
        url: '/events/removeStudent/{{$event->id}}/' + studentID,
        dataType: "json",
        success: function (data, status, jqXhr) {
            location.reload();
        },
        error: function (jqXhr, textStatus, errorMessage) {
            alert('Error: ' + errorMessage);
        }
    });
    */
}

function addStudent(){
    //get student id
    studentID = document.getElementById("add1Student").value;
    myurl='/events/addStudent/{{$event->id}}/' + studentID;
    window.location.href=myurl;

//FIXME: I can't remember how to submit ajax forms, and my documentation really sucks!
//so I'm just using a GET method via URL.

/*    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        async: true,
        url: myurl,
        dataType: "json",
        success: function (msg) {
            location.reload();
        }
    });*/

}
</script>


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

    {{-- if event is in the past, then down show any options that can be changed, including class lists --}}
    @if ( $isPast )
        <div class="card bg-secondary">
        <div class="card-body">
        <h4>The event is in the past and the classlist cannot be modified</h4>
        <h5>so it will not be displayed here.</h5>
        </div>
        </div>
    {{-- @else DEBUG --- REMOVE THIS commenting out !!! --}}

    {{-- normal display for future events --}}
        {{-- if there are students already added, then start with the card collapsed --}}
        @if($studentList->count())
            <div class="card card-dark collapsed-card">
        @else
            <div class="card card-dark">
        @endif
            <div class="card-header" data-widget="collapse">
                <h3 class="card-title">Create Attendance List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" xxdata-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
                </div>
            </div>
        <div class="card-body">
            <h4>Enter a course code to add all students in that course & section to the attendance list for this event.</h4>
                <p>No spaces, No hyphen. e.g. ATC10102</p>
            <form role="form" action="/events/addStudentsByCourse" method="post">                
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
            <h4>Add a student by student number</h4>
            <div class="form-group">                   
                    <div class="input-group">
                        {{--  <a href="#" data-toggle="tooltip" title="" data-original-title="Default tooltip">you probably</a>  --}}
                        <div class="input-group-prepend btn btn-outline-success" for="name">Student number:</div>
                            <input type="text" class="form-control mx-1 col-2 border border-success" id="add1Student" name="add1Student" required autofocus>
                            <button type="submit" class="btn col-1 btn-primary  elevation-3" onclick="addStudent();">Submit</button>
                    </div>          
            </div>
        </div>
        <div class="card-body">
            @if($studentList->count())
                <h5>Students attached to this event</h5>
                
                <p class="text-danger">Click on check boxes to remove student</p>
                <hr>
                <table cellspacing=0 cellpadding=5 class="table-hover table-striped">
                <tr><th>Student Num</th><th>Name</th><th>Remove</th></tr>
                @foreach($studentList as $SL)
                    <tr>
                        <td>{{$SL->student_id}} </td>
                        <td>{{$SL->student['lastname']}}, {{$SL->student['firstname']}} </td> {{-- not $SL->student->lastname --}}
                        <td><input type="checkbox" onclick="removeStudent({{$SL->student_id}})"></td>
                    </tr>
                @endforeach 
                </table>
            @else
            <h5>No students have been attached to this event yet</h5>
            @endif
        </div>
    </div>
    @endif {{-- end of IF to see if $isPast--}}
</div>
@endsection
