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
					<label class="input-group-prepend btn btn-warning" for="name">Group / Team Name</label>
					<input type="text" class="form-control border border-warning" id="name" name="name" value="{{ $kiosk->name }}">
				</div>
				<div class="input-group mb-3">
					<label class="input-group-prepend btn btn-success" for="room">Room Number / Location</label>
					<input type="text" class="form-control border border-success" id="room" name="room" value="{{ $kiosk->room}}">
				</div>
				
				<div class="callout callout-info">
				<!-- all checkboxes -->
				
				<input type="checkbox" id="publicViewable" name="publicViewable" {{ $kiosk->publicViewable ? 'checked' :''}}>
				<label for="publicViewable">Publically Viewable</label> (Kiosk logs are viewable by any logged in user)<br>

				<input type="checkbox" id="signInOnly" name="signInOnly" {{ $kiosk->signInOnly ? 'checked' :''}}>
				<label for="signInOnly">Sign in only</label> 
				<span class="text-danger">If checked, then student is only marked present. There is no signout. 
					<b>Changing this will probably invalidate the existing logged data for this kiosk.</b></span><br>
				
				<input type="checkbox" id="autoSignout" name="autoSignout" {{ $kiosk->autoSignout ? 'checked' :''}}>
				<label for="autoSignout">Auto Signout</label> (If checked, then times can be entered for system to automatically sign students out)<br>
				(This has no effect if "signin only" is checked)<br>
				</div>
				<div class="callout callout-info">

				<input type="checkbox" id="requireConf" name="requireConf" {{ $kiosk->requireConf ? 'checked' :''}}>
				<label for="requireConf">Require Confirmation</label> (require a seperate confirmation step upon sign-in)<br>
				<input type="checkbox" id="showPhoto" name="showPhoto" {{ $kiosk->showPhoto ? 'checked' :''}}>
				<label for="showPhoto">Show Photo</label> (display photo upon signin)<br>
				
				<input type="checkbox" id="showSchedule" name="showSchedule" {{ $kiosk->showSchedule ? 'checked' :''}}>
				<label for="showSchedule">Show Schedule</label> (show student schedule upon sign-in)<br>
				
				
				</div>
			</div>
			<div class="box-footer">
				{{csrf_field()}}
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		</div>
	</form>
	<!-- form end -->
</div>
<!-- /.card-body -->
</div>
	@if($kiosk->users->count())
		<hr>
		<h3>Users</h3>
		<h5 style="border-bottom:solid black 1px;">
			<label class="userlabel">Name</label><label>Kiosk Admin?</label></h5>

		@foreach($kiosk->users as $user)
			<label class="userlabel" for="user-checkbox-{{ $user->id }}" value="{{$user->id}}">{{ $user->fullname }}</label>
			<input type="checkbox" onchange="window.location.href='/kiosks/{{ $kiosk->id }}/users/{{ $user->id }}'" 
				{{ $user->pivot->isKioskAdmin ? 'checked' :''}}>
			<!-- ** NOTE: do not bother with CRSF for this -->
			<label class="userlabel">&nbsp;</label>
			<input type="button" onclick="window.location.href='/kiosks/{{ $kiosk->id }}/detach/{{ $user->id }}'" 
				class="btn btn-xs btn-danger" value="Revoke">					
			<br>
		@endforeach
	
	@endif

	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Add User</h3>
			<!--<p>** NOTE: do not bother with CRSF for this</p> -->
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Select a user and click add</label><br>
						<select onchange="if (this.value) window.location.href=this.value" size="8">
						{{--  <select onchange="if (this.value) alert(this.value)" size="8">  --}}
							<option style="border-bottom:1px solid black;" value="">Select user to add to kiosk</option>
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
		</div>
		@if (session('error'))
			<div class="alert alert-success" role="alert">
				{{ session('error') }}
			</div>
		@endif
	</div>
	
	<h2>&nbsp;</h2>

	<form role="form" action="/kiosks/{{ $kiosk->id }}" method="post">
		{{ method_field('DELETE')}} {{csrf_field()}}
		<button type="submit" class="btn btn-secondary">Delete this Kiosk</button>
	</form>
	
</div>
@endsection
