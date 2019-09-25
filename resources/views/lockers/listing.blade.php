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
    var n1,n2,text;

    n1 = document.getElementById("startnum").value;
	
    // If x is Not a Number or less than one or greater than 10
    if (isNaN(n1) || n1 < 1 || n1 > 3500) {
        text = "Locker number must be between 1 and 3500";
        text = "<div class=\"error\">" + text + "</div>";
        document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-warning w-50\"></div>";
        document.getElementById("error_message").innerHTML = text;
        document.getElementById("startnum").value = "";
        return false;
    }

    n2 = document.getElementById("endnum").value;
    // If x is Not a Number or less than one or greater than 10
    if (isNaN(n2) || n2 < 1 || n2 > 3500) {
        text = "Locker number must be between 1 and 3500";
        text = "<div class=\"error\">" + text + "</div>";
        document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-warning w-50\"></div>";
        document.getElementById("error_message").innerHTML = text;
        document.getElementById("endnum").value = "";
        return false;
    }

	//here + must be used to convert strings to ints.
	if (+n1 >= +n2) {
        text = "Starting number must be lower than ending number";
        text = "<div class=\"error\">" + text + "</div>";
        document.getElementById("error_message").outerHTML = "<div id=\"error_message\" class=\"alert alert-warning w-50\"></div>";
        document.getElementById("error_message").innerHTML = text;
		return false;
	}

	return true;
}

</script>

<!-- display message when this page (re)loads, eg. when a kiosk is deleted -->
@if (session('success'))
	<script>
		window.createNotification({
			theme: 'success',
			positionClass: 'nfc-bottom-right',
			displayCloseButton: true,
			showDuration: 4500
		})({		
			message: '{!! session('success') !!}'
		});
	</script>
	 {{--  <div class="alert alert-danger" role="alert">
	    {{ session('error') }}
	</div>  --}}
@endif

<div class="container">
	<h1>Locker List Maintenance</h1>
	<div class="card">
	<div class="card-body">

 		 <div id="error_message"></div>

		<h4>Assign status to a range of lockers</h4>
		<form role="form" action="/lockers/massAssign" method="post" onsubmit="return validateData()" >
		@csrf
		<div class="row my-2 text-primary">
			<div class="col-md-3">
				Starting locker number
			</div>
			<div class="col-md-3">
				Ending locker number
			</div>
		</div>
		<div class="row my-2">
			<div class="col-md-3">
				<input type="text" maxlength="5" size=5 class="" id="startnum" name="startnum">
			</div>
			<div class="col-md-3">
				<input type="text" maxlength="5" size=5 class="" id="endnum" name="endnum">
			</div>
		</div>

		<div class="row ml-1">
			<div class="col-md-auto py-2 bg-light">
				<span class="text-primary">Select status: </span>
			</div>
			<div class="col-md-auto border border-warning rounded py-2">
				<input id="rb1" required NAME="lstatus" type="radio" value="0"> Available
			</div>
			<div class="col-md-auto border border-warning rounded py-2">
				<input id="rb2" name="lstatus"  type="radio" value="-2"> Nonexistent
			</div>
			<div class="col-md-auto border border-warning rounded py-2">
				<input id="rb3" name="lstatus"  type="radio" value="-1"> Damaged
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="row">
			<div class="col-md-auto text-danger py-1">
			<b>NOTE: this will remove any currently assignned students from the list of lockers above.</b>
			</div>
		</div>
		<button class="btn btn-success" type="submit">Submit</button>
		</form>

	</div>
	</div>

	<div class="card collapsed-card">
    <div class="card-header" data-widget="collapse">
        <h3 class="card-title">Locker Ranges</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
        </div>
    </div>
	<div class="card-body">
		Basement: 1-329<br> 1st floor: 1001-1461<br> 2nd floor: 2001-2435 <br> 3rd floor: 3001-3481
	</div>
	</div>

	<div class="card">
	<div class="card-body">
... reports ...
	</div>
	</div>
</div>

@endsection
