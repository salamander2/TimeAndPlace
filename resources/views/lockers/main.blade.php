@extends('layouts.app') 
@section('content') 
{{--
	<ol class="breadcrumb">
	    <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	    <li class="active"> Kiosks List</li>
	</ol> 
--}} 
<script>
	function getHomeRoom() {
            swal({
                title: "Enter home room",
                text: "(course code with section)",
                //icon: "info",  
                content: {                                
                    element: "input",
                    attributes: {
                    }
                },                
                }).then((coursecode) => {
                    coursecode = coursecode.toUpperCase().trim();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        async: true,
                        url: '/verifyHomeRoom',
                        data: {                            
                            code : coursecode 
                        },
                        dataType: "json",
                        // contentType: "application/json",     //this totally messes up data transfer
                        success: function (msg) {
                            if(msg.status === "success"){
                                window.location = "/lockers/homeroom/" + coursecode;
                            }                            
                            else if(msg.status === "failure"){
                                SWerrormsg("This is not a valid course code");
                            }
                            else if(msg.status === "wrongperiod"){
                                SWerrormsg("This course is not in period 1");
                            }
                            else {
                                SWerrormsg();
                            }

                        },
                        error: function (err) {
                            alert('The ajax query did not run ' + err);
                            console.log(err);
                            //errormsg();
                        }
                    });
                }
            );
		}
		function SWerrormsg(str) {
            if (str.length == 0) str = "There was an unexpected database error!"
            swal({
                title: "ERROR!",
                icon: "error",
                text: str,               
 		        timer:4000,
            }).then(  function() { $('#inputID').focus() }
        	);
        }

        
</script>

<div class="container">
    <h1>Locker List Maintenance</h1>
	<div class="card px-2">
		<div class="row my-2">
			<div class="col-md-3"><span class="my-1 btn btn-success btn-block elevation-1" onclick="getHomeRoom()" href=""> Enter locker info </span></div>
			<div class="col-md my-1"> <h5>- for homeroom teachers</h5></div>
		</div>
        <p>Once information is entered for a locker, the teacher cannot edit it. The secretaries have to edit and change it.</p>
		@if (auth()->user()->isAdministrator() || auth()->user()->username == 'secretary')
		<div class="row my-2">
			<div class="col-md-3"><a class="my-1 btn btn-warning btn-block elevation-1" href="/lockers/edit"> Edit locker information </a></div>
			<div class="col-md my-1"> <h5>- for secretaries</h5></div>
		</div>
		@else
		<div class="row my-2">
			<div class="col-md-3"><span class="my-1 btn btn-dark btn-block disabled elevation-1" href=""> Edit locker information </span></div>
			<div class="col-md my-1"> <h5>- for secretaries</h5></div>
		</div>
		 @endif
        <p>This is where you type in a locker number and edit the fields:<br>
        * available/broken/nonexistent/ <br>
        * combination<br>
        * in use by: student number (it will allow listing of up to 3 students sharing a locker)<br>
        <i>The student number can be looked up by typing in the student's name</i></p>


		@if (auth()->user()->isAdministrator() || auth()->user()->username == 'secretary')
		<div class="row my-2">
			<div class="col-md-3"><a class="my-1 btn btn-info btn-block elevation-1" href="/lockers/listing"> Locker Reports </a></div>
			<div class="col-md my-1"> <h5>- for secretaries</h5></div>
		</div>
		@else
		<div class="row my-2">
			<div class="col-md-3"><span class="my-1 btn btn-dark btn-block disabled elevation-1" href=""> Locker Reports </span></div>
			<div class="col-md my-1"> <h5>- for secretaries</h5></div>
		</div>
		@endif
        <p>This is where you can choose reports to display/print:<br>
        * all available lockers on a certain floor<br>
        * search for a locker by student name</p>
    </div>
</div>    
@endsection
