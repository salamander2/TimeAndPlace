@extends('layouts.app')

{{-- @push('scripts') --}}
{{-- this does nothing yet. Need @stack('scripts') in header.blade.php --}}
<script>
	//TODO: figure out how to stop someone from injecting into this to delete the wrong user.
	//Everything needs the auth and admin middleware. Also do not allow deleting of isAdmin accounts.
	function resetPWD(userID){
		//jQuery.post('/terminals/1/toggleStudent/333444555');
		
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "POST",
			async: true,
			url: 'AJAXresetPWD/' + userID,
			dataType: "json",
			success: function (msg) {
				if(msg.status === "success"){
					$("#pwd"+ userID).html("*");
					window.createNotification({
						theme: 'success',
						positionClass: 'nfc-bottom-right',
						displayCloseButton: true,
						showDuration: 3000
					})({
						title:'Success',
						message: 'Password has been reset'
					});
				}	
			},
			error: function (msg) {
				if (msg.status == 403){
					window.createNotification({
						theme: 'error',
						positionClass: 'nfc-bottom-right',
						displayCloseButton: true,
						showDuration: 4000
					})({
						title:'Forbidden',
						message: 'You are not permitted to reset passwords'
					});

				} else {
					alert('Reset password failed!');
					console.log(msg);
					//errormsg();
				}
			}
		});
	};
	

	function deleteUser(userID){
		//alert('Delete ' + userID);
		
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "POST",
			async: true,
			url: 'AJAXdelUser/' + userID,
			dataType: "json",
			success: function (msg) {
			}
		});
	};

</script>
{{-- @endpush --}}

@section('content')
<div class="container">
	<h1>
		Users <small>All registered users on the system.</small>
	</h1>
	<div class="row ">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header bg-primary">Add New User</div>

				{{-- ************************** section to display status alert (from where?) ***************************** --}}
				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif {{-- ************************** START section to add a new user ***************************** --}}
					<form method="POST" action="{{ route('addUser') }}">
						@csrf
						<!-- MH. Changed to use username instead of email address -->
						<div class="form-group row">
							<label for="username" class="col-md-4 col-form-label text-md-right">{{ __('UserName') }}</label>

							<div class="col-md-6">
								<input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
								 value="{{ old('username') }}" required autofocus> @if ($errors->has('username'))
								<span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span> @endif
							</div>
						</div>

						<div class="form-group row">
							<label for="fullname" class="col-md-4 col-form-label text-md-right">{{ __(' Full Name') }}</label>

							<div class="col-md-6">
								<input id="fullname" type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname"
								 value="{{ old('fullname') }}" required> @if ($errors->has('fullname'))
								<span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fullname') }}</strong>
                                    </span> @endif
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
							</div>
						</div>
					</form>
						{{-- ************************* END section to add a new user ***************************** --}}
				</div>
			</div>
			<div class="card">

				<div class="card-header bg-info">User Listing</div>
				<div class="card-body">

					{{-- ************************** START section to display, modify, delete all users ***************************** --}}
					<table>
						<tr style="border-bottom:solid black 1px">
							<th>Username ...&nbsp;</th>
							<th> Full Name</th>
							<!-- <th>isAdmin</th> -->
							<th>&nbsp;</th>
							<th>Default PWD</th>
						</tr>
						@foreach($users as $user)
						<tr>
							<td style="color:black;">{{ $user->username }}</td>
							<td style="color:black;">{{ $user->fullname }}</td>

							<td>&nbsp;&nbsp;<button type="button" name="resetPWD" class="btn btn-secondary"
								onclick="if(confirm('Please confirm password reset ')) resetPWD({{ $user->id }});">Reset Password</button>
							</td>
							<td style="color:black;text-align:center" id="pwd{{ $user->id }}">@if ($user->defaultPWD == 1) * @endif
							</td>
							<td><button type="button" name="delete" class="btn btn-outline-danger"
								onclick="if(confirm('Are you sure?')) deleteUser({{ $user->id }});">Delete</button>
							</td>
							
							
						</tr>

						@endforeach
					</table>
				</div>
			</div>
			<div class="links">
				
				<!-- check the session variable that was created by the controller -->
				@if (session('error'))
				<a class="btn btn-info" href="{{ route('hideDefaultPWD') }}"><b>Hide default password</b></a>
				<div class="alert alert-danger" role="alert">
					<p>Default password: {{ session('error') }} </p>
				</div>
				@else 
				<a class="btn btn-success" href="{{ route('showDefaultPWD') }}"><b>Show default password</b></a>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
