@extends('layouts.app')
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a> </li>
        <li class="active"> Users</li>
    </ol>

@section('content')
<div class="container">
    <h1>
        Users
        <small>All registered users on the system.</small>
    </h1>
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">User Maintenance</div>

			{{-- ************************** section to display status alert (from where?)  ***************************** --}}
				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif


			{{-- ************************** START section to add a new user ***************************** --}}
                    <form method="POST" action="{{ route('addUser') }}">
                        @csrf
						<!-- MH. Changed to use username instead of email address -->
                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('UserName') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="fullname" class="col-md-4 col-form-label text-md-right">{{ __(' Full Name') }}</label>

                            <div class="col-md-6">
                                <input id="fullname" type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" value="{{ old('fullname') }}" required>

                                @if ($errors->has('fullname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fullname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
			{{-- ************************* END section to add a new user ***************************** --}}


					<hr>
			{{-- ************************** START section to display, modify, delete all users ***************************** --}}
					<table>
					@foreach($users as $user) 
						<tr>
						<td style="color:black;" >{{ $user->username }}</td>
						<td style="color:black;" >{{ $user->fullname }}</td>
						<td style="color:black;"><input id="isTeam_row1" type="checkbox" value="isTeam"></td>
						<td><button type="submit" onclick="updateRow(1,akirkham')">Update</button></td>
						<td><a href="deleteUser.php?ID=akirkham"><button type="submit" name="delete" style="color:red;" onclick="return confirm('Are you sure?');" >Delete</button></a></td>
						<td><a href="resetPWD.php?ID=akirkham"><button type="submit" name="changePWD" onclick="return confirm('Are you sure?');" >Reset Password</button></a></td>
						<td style="color:black;">{{ $user->defaultPWD }}</td></tr>

					@endforeach
					</table>
				</div>
				<div class="links">
					<p><a href="{{ route('showDefaultPWD') }}">Show default password:</a></p>
					@if (session('error'))
					<div class="alert alert-danger" role="alert">
						<p>Default password: {{ session('error') }} </p>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
