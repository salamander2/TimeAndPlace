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
                                                                                                                                                                                                         
    // Get the value of the input field with id="grade"                                                                                                                                                  
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
        
    <button class="btn btn-success" type="submit">Submit</button>
    </form>
    <div class="row my-1" style="border-bottom:solid black 1px;"> </div>

    <div id="lockerInfo"></div>
    @isset($locker)
    <h2>Locker # {{$locker->id }}</h2>
    <h5>Status: <kbd>{{$status}}</kbd> </h5>
    <form action="/lockers/setStatus/{{$locker->id}}" method="post">
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
        <div class="col-md-auto py-1 rounded border border-warning bg-light">Selecting any of these will remove any students from the locker</div>
    </div>
    </form>
                                        
    <br clear="both">
    <hr>
    <h4>Combination : <kbd>{{$locker->combination}}</kbd> 
    <input type="text" id="newcombo" name="newcombo" placeholder="Enter new combination">
    <button class="btn btn-success" type="submit">Submit</button>
    </h4>
    <h4>Used by:</h4>
    @foreach ($studentList as $student) 
        <h5>{{$student->studentID}} :  {{$student->lastname}}, {{$student->firstname}} <button class="btn btn-outline-danger" type="submit">Remove</button></h5>
    @endforeach
    <i>(TODO add in options to add and remove students and to change the combination)</i>
    @endisset


    </div>
</div>    
@endsection
