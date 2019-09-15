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
                    //placeholder: "password ...",
                    }
                },                
                }).then((coursecode) => {
                   // swal(`The returned value is: ${password}`);
                   // pwd = {{ Hash::make('password') }}

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
                                showOverlay();
                            }                            
                            else{
                                SWerrormsg("This is not a valid course code (or not a homeroom?) ");
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
            if (str.length == 0) str = "The student was not found or there was an unexpected database error!"
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
	<div class="card">
		<div class="row mx-2 my-2">
			<div class="col-md-3"><span class="my-1 btn btn-success btn-block elevation-1" onclick="getHomeRoom()" href="/lockers/homeroom"> Enter locker info </span></div>
			<div class="col-md my-1"> <h5>- for homeroom teachers</h5></div>
		</div>
		@if (auth()->check() && auth()->user()->username == 'secretary'))
		<div class="row mx-2 my-2">
			<div class="col-md-3"><a class="my-1 btn btn-warning btn-block elevation-1" href="/terminals/"> Edit locker information </a></div>
			<div class="col-md my-1"> <h5>- for secretaries</h5></div>
		</div>
		@else
		<div class="row mx-2 my-2">
			<div class="col-md-3"><span class="my-1 btn btn-dark btn-block disabled elevation-1" href=""> Edit locker information </span></div>
			<div class="col-md my-1"> <h5>- for secretaries</h5></div>
		</div>
		 @endif

		@if (auth()->check() && auth()->user()->username == 'secretary'))
		<div class="row mx-2 my-2">
			<div class="col-md-3"><a class="my-1 btn btn-info btn-block elevation-1" href="/terminals/"> Locker Reports </a></div>
		</div>
		@else
		<div class="row mx-2 my-2">
			<div class="col-md-3"><span class="my-1 btn btn-dark btn-block disabled elevation-1" href=""> Locker Reports </span></div>
			<div class="col-md my-1"> <h5>- for secretaries</h5></div>
		</div>
		@endif
    </div>
</div>    
@endsection
