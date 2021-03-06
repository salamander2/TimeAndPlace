@extends('layouts.app')
@section('content')
{{--
	<ol class="breadcrumb">
	    <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	    <li class="active"> Kiosks List</li>
	</ol>
--}}
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
             @if($studentList->count())

                <div class="row my-1" style="border-bottom:solid black 1px;">
                <div class="col-md-4"><b>Student</b></div>
                <div class="col-md-1"><b>Locker#</b></div>
                <div class="col "><b>Combination #</b></div>
                </div>

                @foreach($studentList as $SL)
                {{-- start one row of data --}}
                    {{-- <form role="form" action="/lockers/{{$SL->studentID}}" method="post"> --}}
                    <form role="form" action="/lockers/student/{{$SL->studentID}}" method="post" onsubmit="return validateForm({{$SL->studentID}})">
                    @csrf
                @if ($loop->iteration %2 == 0)
                    <div class="row py-1" style="background-color:#DDD;">
                 @else
                    <div class="row py-1">
                @endif
                    <div class="col-md-4">
                    <span style="color:#600;">{{$loop->iteration }}.</span>&nbsp;&nbsp;{{$SL->studentID}} : {{$SL->lastname}}, {{$SL->firstname}}
                    </div>
                    {{-- NOTE that we only have to append the studentID to the 'id' not the name. The 'id' is checked for validation. 
                         If valid, the name goes to the form. --}}
                    <div class="col-md-1"> <input type="text" maxlength="5" size=5 class="" id="lockerNum{{$SL->studentID}}" name="lockerNum"> </div>
                    <div class="col"> <input type="text" class="" id="combination{{$SL->studentID}}" name="combination"> </div>
                    <div class="col">
                    <input type="hidden"  name="studentID" id="studentID" value = "{{$SL->studentID}}">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                    </form>
                @endforeach



            @endif
        </div>
    </div>
</div>
@endsection
