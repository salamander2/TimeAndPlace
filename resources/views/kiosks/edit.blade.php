@extends('layouts.app')

@section('content')
<div class="container">
	<h1>
		Edit Kiosk
	</h1>

	<!-- form start -->
	<form role="form" action="/kiosks/{{ $kiosk->id }}" method="post">
		{{ method_field('PATCH') }}
		<div class="box-body">
			<div class="form-group">
				<label for="name">Group / Team Name</label>
				<input type="text" class="form-control" id="name" name="name" value="{{ $kiosk->name }}">
				<label for="room">Room Number / Location</label>
				<input type="text" class="form-control" id="room" name="room" value="{{ $kiosk->room}}">
				<!-- all checkboxes -->
				<label for="showPhoto">Show Photo</label>
				<input type="checkbox" id="showPhoto" name="showPhoto" {{ $kiosk->showPhoto ? 'checked' :''}}>
				<label for="showSchedule">Show Schedule</label>
				<input type="checkbox" id="showSchedule" name="showSchedule" {{ $kiosk->showSchedule ? 'checked' :''}}>
				<label for="requireConf">Require Confirmation</label>
				<input type="checkbox" id="requireConf" name="requireConf" {{ $kiosk->requireConf ? 'checked' :''}}>
				<label for="publicViewable">Publically Viewable</label>
				<input type="checkbox" id="publicViewable" name="publicViewable" {{ $kiosk->publicViewable ? 'checked' :''}}>
				<label for="signInOnly">Sign in only</label>
				<input type="checkbox" id="signInOnly" name="signInOnly" {{ $kiosk->signInOnly ? 'checked' :''}}>
				<label for="autoSignout">Auto Signout</label>
				<input type="checkbox" id="autoSignout" name="autoSignout" {{ $kiosk->autoSignout ? 'checked' :''}}>

			</div>
			<div class="box-footer">
				{{csrf_field()}}
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		</div>
	</form>
	<!-- form end -->

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
							
							@foreach(\App\User::all() as $user)
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
