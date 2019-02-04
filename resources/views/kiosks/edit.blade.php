@extends('layouts.app') @push('scripts')
<script>
	function removeUserFromKiosk(userid) {

			var url = "/kiosks/{{$kiosk->id}}/detach/" + userid;
			$.ajax({
				url: url,
				type: "DELETE",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function (result) {
					location.reload();
				}
			});
		}

	function addUserToKiosk() {
		var userArray = $("#addUserSelector").val();
		var i = 0;
		userArray.forEach(function (val) {
			i++;
			var url = "/kiosks/{{$kiosk->id}}/attach/" + val;
			$.ajax({
				url: url,
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				success: function () {
					if (i = userArray.length) {
						location.reload();
					}
				}

			});

		});
	}

</script>
<script>
	var addUserBox = $('.user-add-box').select2();

</script>



@endpush 
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
	</form>
	<!-- form end -->

	<!-- List kiosk users -->

	@if($kiosk->users->count())
	<hr>
	<h3>Users</h3>
	<h5 style="border-bottom:solid black 1px;"><label class="userlabel">Name</label><label>Kiosk Admin?</label></h5>
	
	@foreach($kiosk->users as $user)



	<form action="/kiosks/{{ $kiosk->id }}/users/{{ $user->id }}" method="POST" style=" display:inline!important;">
		@csrf @method('PATCH')
		<label class="userlabel" for="user-checkbox-{{ $user->id }}" value="{{$user->id}}">{{ $user->fullname }}</label>
		<input type="checkbox" name="completed" id="user-checkbox-{{ $user->id }}" onChange="this.form.submit()" {{ $user->pivot->isKioskAdmin
		? 'checked' :''}}>

	</form>
	<button onclick="removeUserFromKiosk({{$user->id}})" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Revoke	</button>
	<br>
	 @endforeach 
	
	@endif

	</div>
	<hr>
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">Add User</h3>


		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Select a user and click add</label><br>
						<select class="user-add-box" style="width: 100%;" id="addUserSelector" multiple="multiple">

								@foreach(\App\User::all() as $user)
									<option value="{{$user->id}}">{{ucfirst($user->fullname)}}</option>
								@endforeach
							</select>
					</div>
					<button type="button" class="btn btn-block btn-success" onClick="addUserToKiosk()">Add User	to Kiosk
						</button>


				</div>
			</div>
		</div>

	</div>




	<!-- /.box-body -->



	<form role="form" action="/kiosks/{{ $kiosk->id }}" method="post">
		{{ method_field('DELETE')}} {{csrf_field()}}
		<button type="submit" class="btn btn-secondary">Delete</button>

	</form>
</div>
@endsection