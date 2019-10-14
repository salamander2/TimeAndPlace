@extends('layouts.app')
@section('content')
{{--
	<ol class="breadcrumb">
	    <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	    <li class="active"> Kiosks List</li>
	</ol>
--}}

<!-- note! I'm not using AJAX to rewrite the row when it is submitted. Reloading the page works just fine. --->
<script>
function validateForm(studentID) {
    var x;

    // Get the value of the input field with id="grade"
    x = document.getElementById("lockerNum"+studentID).value;

    // If x is Not a Number or less than one or greater than 10
    if (isNaN(x) || x < 1 || x > 3500) {
        text = "Locker number must be between 1 and 3500";
        text = "<div class=\"error\">" + text + "</div>";
        document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-warning w-50\"></div>";
        document.getElementById("error_message").innerHTML = text;
        //document.getElementById("lockerNum").value = "";
        return false;
    }
    var c = document.getElementById("combination"+studentID).value;
    if (!c || 0 === c.length) {
        text = "No combination entered";
        text = "<div class=\"error\">" + text + "</div>";
        document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-warning w-50\"></div>";
        document.getElementById("error_message").innerHTML = text;
        return false;
    }
    return true;
}
</script>

<div class="container">
    <h1>Homeroom Locker Entry</h1>

    <div id="error_message"></div>

    <div class="card card-info">
        <div class="card-body">
        <h3>{{ $coursecode }}</h3>
             {{-- @if($array->count()) --}}

                <div class="row my-1" style="border-bottom:solid black 1px;">
                <div class="col-md-4"><b>Student</b></div>
                <div class="col-md-1"><b>Locker#</b></div>
                <div class="col "><b>Combination #</b></div>
                </div>

                @foreach($array as $row)
                    {{-- $row[0] = studentID, $row[1] = lname,fname, $row[2] = locker_id, $row[3] = combination;   --}}
                    {{-- start one row of data --}}
                    {{-- <form role="form" action="/lockers/{{$SL->studentID}}" method="post"> --}}
                    <form role="form" action="/lockers/student/{{$row[0]}}" method="post" onsubmit="return validateForm({{$row[0]}})">
                    @csrf
                @if ($loop->iteration %2 == 0)
                    <div class="row py-1" style="background-color:#DDD;">
                 @else
                    <div class="row py-1">
                @endif
                    <div class="col-md-4">
                    <span style="color:#600;">{{$loop->iteration }}.</span>&nbsp;&nbsp;{{$row[0]}} : {{$row[1]}}
                    </div>
                    @if($row[2] == "")
                    {{-- NOTE that we only have to append the studentID to the 'id' not the name. The 'id' is checked for validation. 
                         If valid, the name goes to the form. --}}
                    <div class="col-md-1"> 
                        <input type="text" maxlength="5" size=5 class="" id="lockerNum{{$row[0]}}" name="lockerNum"> 
                    </div>
                    <div class="col"> <input type="text" class="" id="combination{{$row[0]}}" name="combination"> </div>
                    <div class="col">
                    <input type="hidden"  name="studentID" id="studentID" value = "{{$row[0]}}">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                    @else
                    <div class="col-md-1"> 
                        <input style="color:black;" disabled type="text" maxlength="5" size=5 class="" id="lockerNum{{$row[0]}}" name="lockerNum" value="{{$row[2]}}"> 
                    </div>
                    <div class="col"> <input disabled type="text" class="" id="combination{{$row[0]}}" name="combination" value="{{$row[3]}}"> </div>
                    <div class="col">
                                <div class="input-group-append" style="visibility:hidden;">
                                    <button class="btn" type="button">Submit</button>
                                </div>
                            </div>
                    @endif
                </div>
                    </form>
                @endforeach

            {{-- @endif --}}
        </div>
    </div>
</div>
@endsection
