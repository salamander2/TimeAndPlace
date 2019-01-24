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
			<div class="form-group">
					<label for="adminName">Admin / users?</label>
					<input type="text" class="form-control" id="adminName" name="adminName">
			</div>

		</div>

		<!-- /.box-body -->

		<div class="box-footer">
			{{csrf_field()}}
			<button type="submit" class="btn btn-primary">Update</button>
		</div>
	</form>
	<!-- form end -->
</div>
@endsection