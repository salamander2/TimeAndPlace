@extends('layouts.app') 
@section('content') 
{{--
	<ol class="breadcrumb">
	    <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	    <li class="active"> Kiosks List</li>
	</ol> 
--}} 
<script> 
function validateData() {                                                                                                                                                                                
    var x; 
    x = document.getElementById("coursecode").value;  
    document.getElementById("coursecode2").value = x;  
    return true;
}
</script>

<div class="container">
    <h1>Class Lists <span style="font-size:50%;">(printable)</span></h1>
    <div class="card card-info">
        <div class="card-body">
        <h3></h3>

    <div id="error_message"></div>

    <div class="row">
    <form name="form1" id="form1" role="form" action="/classlists/show" method="post">
    @csrf
    Enter course code: <input type="text" class="" id="coursecode" name="coursecode"> &nbsp;
        
    <button class="btn btn-success p-1" type="submit">List students</button> 
    </form>
    <form name="form1" id="form1" role="form" action="/classlists/showContacts" onsubmit="return validateData();" method="post">
    @csrf
    <input type="hidden" class="" id="coursecode2" name="coursecode" value=""> &nbsp;
    <button class="btn btn-warning p-1" type="submit" onclick="validateData();">List contact info</button> <br>
    </form>
    </div>
    <span class="text-secondary">e.g. ENG2D1-01  or ENG2D101 (or lower case)</span>    
    <div class="row my-1" style="border-bottom:solid black 1px;"> </div>

        To see a list of all courses this semester, click on the <span class="btn btn-primary"><i class="fa fa-th-large"></i></span> in the top right.
   </div> <!-- end of card body -->
    </div> <!-- end of card -->
</div>    
@endsection
