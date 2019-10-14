@extends('layouts.app')
@section('content')
{{--
	<ol class="breadcrumb">
	    <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	    <li class="active"> Kiosks List</li>
	</ol>
--}}

{{--
This is the page that edits a locker. If no locker is selected the path is /lockers/edit  and it just shows the top part of the screen.

Once a locker number is selected, then it will show status, etc. and allow you to change things.

--}}


<script>
function validateData() {
    var x, text;

    x = document.getElementById("lockerNum").value;
    // If x is Not a Number or less than one or greater than 10
    if (isNaN(x) || x < 1 || x > 3500) {
        text = "Locker number must be between 1 and 3500";
        text = "<div class=\"error\">" + text + "</div>";
        document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-warning w-50\"></div>";
        document.getElementById("error_message").innerHTML = text;
        document.getElementById("lockerNum").value = "";
        return false;
    }
    document.getElementById("form1").action = "/lockers/edit/" + x;
    return true;
}
function validateData5() {
    var x,y,text;

    x = document.getElementById("addStudentID").value;
    // If x is empty or Not a Number
    if (!x || x.length === 0 || isNaN(x)) {
        text = "You must enter a numeric student id";
        text = "<div class=\"error\">" + text + "</div>";
        document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-danger w-50\"></div>";
        document.getElementById("error_message").innerHTML = text;
        document.getElementById("lockerNum").value = "";
        return false;
    }

    //this ID might not exist, so check first:
    y = document.getElementById("newcombo5"); //from form 5 (there is another newcombo ID on this page!)
    if(y) {
        x = y.value;
        // If x is empty
        if (!x || x.length === 0) {
            text = "You must enter a locker combination";
            text = "<div class=\"error\">" + text + "</div>";
            document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-danger w-50\"></div>";
            document.getElementById("error_message").innerHTML = text;
            document.getElementById("lockerNum").value = "";
            return false;
        }
    }
    return true;
}
</script>

<div class="container">
    <h1>Locker Information</h1>
    <div class="card card-info">
        <div class="card-body">
        <h3></h3>

    <div id="error_message"></div>

    <form name="form1" id="form1" role="form" action="" onsubmit="return validateData()" method="post">
    @csrf
    Enter locker number: <input type="text" maxlength="5" size=5 class="" id="lockerNum" name="lockerNum">

    <button class="btn btn-success p-1" type="submit">Search</button>
    </form>
    <div class="row my-1" style="border-bottom:solid black 1px;"> </div>

    <div id="lockerInfo"></div> {{-- I forget why this is here --}}
@isset($locker)  {{-- this is for when the page is called with NO LOCKER -- then the variable $locker will be null --}}
    <h2>Locker # {{$locker->id }}</h2>
    <h5>Status: <kbd>{{$status}}</kbd> </h5>
    <form name="form2" id="form2" action="/lockers/setStatus/{{$locker->id}}" method="post">
    @csrf
     <div class="row bg-warning ml-2 float-left rounded">
        <div class="col-md-auto py-2 bg-light">
        <input id="rb1" disabled name="lstatus" type="radio" value="1" > Assigned
        </div>
        <div class="col-md-auto py-2">
        <input id="rb1" style="border:solid 1px gray;" name="lstatus" type="radio" value="0" onchange="this.form.submit()"> Available
        </div>
        <div class="col-md-auto py-2">
        <input id="rb2" name="lstatus"  type="radio" value="-2" onchange="this.form.submit()"> Nonexistent
        </div>
        <div class="col-md-auto py-2">
        <input id="rb3" name="lstatus"  type="radio" value="-1" onchange="this.form.submit()"> Damaged
        </div>
        <div class="col-md-auto py-1 rounded border border-warning bg-light">Clicking on any of these will remove
        all students from this locker</div>
    </div> <!--end of row -->
    </form>

    <br clear="both">
    @if($locker->status == 1) {{-- Only allow combination to be changed if locker is being used --}}
    <hr>
    <div class="row">
        <div class="col-md-auto py-2 bg-light">
            <h4>Combination :
            @if($locker->combination != null)
             <kbd>{{$locker->combination}}</kbd>
             @endisset
            </h4>
        </div>
        <div class="col-md-auto py-2 bg-light">
            <form name="form3" id="form3" action="/lockers/newCombo/{{$locker->id}}" method="post">
            @csrf
            <input type="text" id="newcombo" name="newcombo" placeholder="Enter new combination">
            <button class="btn btn-success p-1" type="submit">Submit</button>
            </form>
        </div>
    </div> <!-- end of row -->
    @endif
    <hr>
    @if($locker->status == 1) {{-- Only allow deletion if locker is being used --}}
        <h4>Used by:</h4>
        @foreach ($studentList as $student)
            <form name="form4" id="form4" action="/lockers/delStudent/{{$locker->id}}" method="post">
            @csrf
            <h5>{{$student->studentID}} :  {{$student->lastname}}, {{$student->firstname}}
            <button class="btn btn-outline-danger" type="submit">Remove</button></h5>
            <input type="hidden" name="delStudentID" id="delStudentID" value="{{$student->studentID}}">
            </form>
        @endforeach
    @endif

    @if($locker->status >= 0) {{-- Only allow students to be added if locker is available or assigned--}}
        <form name="form5" id="form5" action="/lockers/addStudent/{{$locker->id}}" onsubmit="return validateData5()" method="post">
        @csrf
        <input type="text" id="addStudentID" name="addStudentID" placeholder="Student ID">
        @if($locker->status == 0) {{-- add in field for combination --}}
            <br><input class="mt-2" type="text" id="newcombo5" name="newcombo" placeholder="Enter new combination">
        @endif
        <button class="btn btn-success p-1" type="submit">Add student to locker</button>
        </form>
    @endif
@endisset
    </div> <!-- end of card body -->
    </div> <!-- end of card -->
</div>
@endsection
