@extends('layouts.app')

@section('content')
<div class="container">
	<h1>
		Edit Kiosk : {{ $kiosk->name }}
	</h1>
	<div class="card card-dark">
			<div class="card-header">
			  <h3 class="card-title">Kiosk Settings</h3>			  
			</div>
			<!-- /.card-header -->
			<div class="card-body">
			  
			
	<!-- form start -->
	<form role="form" action="/kiosks/{{ $kiosk->id }}" method="post">
		{{ method_field('PATCH') }}
		<div class="box-body">
			<div class="form-group">
					
				<div class="input-group mb-3">		  
					<label class="input-group-prepend btn btn-success" for="name">Group / Team Name</label>
					<input type="text" class="form-control border border-success" id="name" name="name" value="{{ $kiosk->name }}">
				</div>
				<div class="input-group mb-3">
					<label class="input-group-prepend btn btn-success" for="room">Room Number / Location</label>
					<input type="text" class="form-control border border-success" id="room" name="room" value="{{ $kiosk->room}}">
				</div>
				
				<div class="callout callout-info">
				<!-- all checkboxes -->
				
				<div class="row my-1">
				<div class="col-md-auto">
						<input type="checkbox" id="publicViewable" name="publicViewable" {{ $kiosk->publicViewable ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="publicViewable">Publically Viewable</label></div>
				<div class="col border ">Kiosk logs are viewable by any logged in user</div>				
				</div><!-- end row -->

				<div class="row my-1">
				<div class="col-md-auto">
					<input type="checkbox" id="signInOnly" name="signInOnly" {{ $kiosk->signInOnly ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="signInOnly">Sign in only</label></div>
				<div class="col border text-danger">If checked, then student is only marked present. There is no signout.<br> 
						<b>Changing this will probably invalidate the existing logged data for this kiosk.</b></div>				
				</div><!-- end row -->
				
				<div class="row my-1">
				<div class="col-md-auto">
					<input type="checkbox" id="autoSignout" name="autoSignout" {{ $kiosk->autoSignout ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="autoSignout">Auto Signout</label></div>
				<div class="col border"> If checked, then times can be entered for system to automatically sign students out.<br>
					This has no effect if "signin only" is checked.</div>
				</div><!-- end row -->
				
				
				</div>

				<div class="callout callout-info">
				
				<div class="row my-1">
				<div class="col-md-auto">
						<input type="checkbox" id="requireConf" name="requireConf" {{ $kiosk->requireConf ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="requireConf">Require Confirmation</label></div>
				<div class="col border ">Require a seperate confirmation step upon sign-in.</div>				
				</div><!-- end row -->
				
				<div class="row my-1">
				<div class="col-md-auto">
						<input type="checkbox" id="showPhoto" name="showPhoto" {{ $kiosk->showPhoto ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="showPhoto">Show Photo</label></div>
				<div class="col border ">Display student photo upon sign-in</div>				
				</div><!-- end row -->

				<div class="row my-1">
				<div class="col-md-auto">
					<input type="checkbox" id="showSchedule" name="showSchedule" {{ $kiosk->showSchedule ? 'checked' :''}}>
				</div>
				<div class="col-md-2 bg-primary"><label for="showSchedule">Show Schedule</label></div>
				<div class="col border">Show student schedule upon sign-in</div>				
				</div><!-- end row -->

				</div><!-- end callout -->
			</div>
			<div class="box-footer">
				{{csrf_field()}}
				<button type="submit" class="btn btn-warning elevation-3">Update</button>
			</div>
		</div>
	</form>
	<!-- form end -->
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
				   <input type="checkbox" onchange="window.location.href='/kiosks/{{ $kiosk->id }}/users/{{ $user->id }}'" 
							 {{ $user->pivot->isKioskAdmin ? 'checked' :''}}>
						 <!-- ** NOTE: do not bother with CRSF for this -->
				</div>
				<div class="col">
				   <input type="button" onclick="window.location.href='/kiosks/{{ $kiosk->id }}/detach/{{ $user->id }}'" class="btn btn-outline-danger" value="Revoke">
				</div>				
			 </div><!-- end row -->


			{{--  <label class="userlabel" for="user-checkbox-{{ $user->id }}" value="{{$user->id}}">{{ $user->fullname }}</label>
			<input type="checkbox" onchange="window.location.href='/kiosks/{{ $kiosk->id }}/users/{{ $user->id }}'" 
				{{ $user->pivot->isKioskAdmin ? 'checked' :''}}>
			<!-- ** NOTE: do not bother with CRSF for this -->
			<label class="userlabel">&nbsp;</label>
			<input type="button" onclick="window.location.href='/kiosks/{{ $kiosk->id }}/detach/{{ $user->id }}'" 
				class="btn btn-outline-danger" value="Revoke">					
			<br>  --}}
		@endforeach
	
	@endif

	<br><Br>
	
	
			<h3>Add User</h3>
			<!--<p>** NOTE: do not bother with CRSF for this</p> -->
		
		
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						{{--  <label>Select a user and click add</label><br>  --}}
						<select class="bg-secondary form-control" onchange="if (this.value) window.location.href=this.value" size="8">
						{{--  <select onchange="if (this.value) alert(this.value)" size="8">  --}}
							<option style="border-bottom:1px solid black;" value="">Click on user to add to kiosk</option>
							{{--  $kioskusers = KioskUser::where([['kiosk_id', $kiosk->id],['user_id', $user->id]])->get();  --}}
							{{--  $detachedUsers = Kiosk::where(id, '=', $kiosk->id);  --}}
							@foreach ( $detachedUsers as $user)
								
							
							{{--  @foreach(\App\User::all() as $user)  --}}
									{{-- @foreach($detachedUsers as $user) --}}
									{{-- {{$user->notThisKiosk($kiosk->id) }} --}}
									<option value="/kiosks/{{ $kiosk->id }}/attach/{{ $user->id }}">{{ucfirst($user->fullname)}}</option>
								
							@endforeach
							
						</select>
						
					</div>

				</div>
			</div>
			

		@if (session('error'))
			<div class="alert alert-success" role="alert">
				{{ session('error') }}
			</div>
		@endif
	
</div>
</div><!-- end card -->
	
<div class="clearfix">
	<form class="float-right" role="form" action="/kiosks/{{ $kiosk->id }}" method="post">
		{{ method_field('DELETE')}} {{csrf_field()}}
		<button type="submit" class="btn btn-danger">Delete this Kiosk</button>
	</form>
</div>
</div>
@endsection
