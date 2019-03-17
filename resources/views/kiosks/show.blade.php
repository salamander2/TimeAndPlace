@extends('layouts.app')

@section('content')
<div id="showKiosk" class="container">
	<h1>
		Show Kiosk Settings : {{ $kiosk->name }}
	</h1>
	<div class="card card-dark">
			<div class="card-header">
			  <h3 class="card-title">Kiosk Settings</h3>			  
			</div>
			<!-- /.card-header -->
			<div class="card-body">
			  
		
	
		<div class="box-body">
			<div class="form-group">
					
				<div class="input-group mb-3">		  
					<label class="input-group-prepend btn btn-success" for="name">Group / Team Name</label>
					<input type="text" class="form-control border border-success" disabled id="name" name="name" value="{{ $kiosk->name }}">
				</div>
				<div class="input-group mb-3">
					<label class="input-group-prepend btn btn-success" for="room">Room Number / Location</label>
					<input type="text" class="form-control border border-success" id="room" disabled name="room" value="{{ $kiosk->room}}">
				</div>
				
				<div class="callout callout-info">
				<!-- all checkboxes -->
				
				<div class="row my-1">
				<div class="col-md-auto">
						<input type="checkbox" disabled id="publicViewable" name="publicViewable" {{ $kiosk->publicViewable ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="publicViewable">Publically Viewable</label></div>
				<div class="col border border-primary">Kiosk logs are viewable by any logged in user</div>				
				</div><!-- end row -->

				<div class="row my-1">
				<div class="col-md-auto">
					<input type="checkbox" disabled id="signInOnly" name="signInOnly" {{ $kiosk->signInOnly ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="signInOnly">Sign in only</label></div>
				<div class="col border border-primary text-danger">If checked, then student is only marked present. There is no signout.<br> 
						<b>Changing this will probably invalidate the existing logged data for this kiosk.</b></div>				
				</div><!-- end row -->
				
				<div class="row my-1">
				<div class="col-md-auto">
					<input type="checkbox" disabled id="autoSignout" name="autoSignout" {{ $kiosk->autoSignout ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="autoSignout">Auto Signout</label></div>
				<div class="col border border-primary"> If checked, then times can be entered for system to automatically sign students out.<br>
					This has no effect if "signin only" is checked.</div>
				</div><!-- end row -->
				
				
				</div>

				<div class="callout callout-info">
				
				<div class="row my-1">
				<div class="col-md-auto">
						<input type="checkbox" disabled id="requireConf" name="requireConf" {{ $kiosk->requireConf ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="requireConf">Require Confirmation</label></div>
				<div class="col border border-primary">Require a seperate confirmation step upon sign-in.</div>				
				</div><!-- end row -->
				
				<div class="row my-1">
				<div class="col-md-auto">
						<input type="checkbox" disabled id="showPhoto" name="showPhoto" {{ $kiosk->showPhoto ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="showPhoto">Show Photo</label></div>
				<div class="col border border-primary">Display student photo upon sign-in</div>				
				</div><!-- end row -->

				<div class="row my-1">
				<div class="col-md-auto">
					<input type="checkbox" disabled id="showSchedule" name="showSchedule" {{ $kiosk->showSchedule ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="showSchedule">Show Schedule</label></div>
				<div class="col border border-primary">Show student schedule upon sign-in</div>				
				</div><!-- end row -->

				</div><!-- end callout -->
			</div>
			
		</div>
	
</div>
<!-- /.card-body -->
</div><!-- end card -->

<div class="card card-dark">
		<div class="card-header">
		  <h3 class="card-title">Kiosk Users</h3>			  
		</div>
		<div class="card-body">	
	@if($kiosk->users->count())
				
		<div class="row my-1" style="border-bottom:solid black 1px;">
			<div class="col-md-2">Name</div>
			<div class="col ">Kiosk Admin?</div>
		</div>
		@foreach($kiosk->users as $user)
		<div class="row py-1">
				<div class="col-md-2 bg-primary">
				   <label for="user-checkbox-{{ $user->id }}" value="{{$user->id}}">{{ $user->fullname }}</label></div>
				<div class="col-md-2">
				   <input type="checkbox" disabled {{ $user->pivot->isKioskAdmin ? 'checked' :''}}>						 
				</div>
								
		</div><!-- end row -->

		@endforeach
	
	@endif


	</div>
</div><!-- end card -->


</div>
@endsection
