<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.headLinks')
    @stack('styles')
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  
</head>
          
<body class="login-page" style="height:auto;"> 
    
    <div class="login-box bg-primary border border-dark rounded" style="width:440px;margin-top:7vh;">
        <div class="login-logo">
            <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3 my-3" style="opacity: .8">
            <span class="brand-text font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
        </div>
		<div class="text-center">
			<h4>Student Tracker and <br>Student Information System</h4>
		</div>
    </div>
    <!-- /.login-logo -->

    <div class="container col-md-6">
        
        <div class="card border-dark ">
            <div class="card-header bg-dark text-center"><h3><i class="fa fa-tag"> </i> Sign in to start your session</h3>
                <h5>Use Teacher login to view logs</h5>
            </div>  


		<div class="card-body login-card-body">
                        
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                        {{-- dd($errors) --}}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">                                        
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

<!--
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
-->
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary elevation-4">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

			@if ( env('DEMO') )
				<div class="card border-info">
				<div class="card-body">
					<h4>For demonstration database:</h4>
					<table class="table table-bordered table-sm" style="width:auto">
					<thead>
					<tr class="table-primary text-center"><th>Logins</th><th>Role</th><th>Details</th></tr>
					</thead>
					<tbody>
					<tr><td>admin</td><td>Administrator </td><td>(create users and kiosks)</td></tr>
					<tr><td>teacher</td><td>Generic user</td><td> (view-only)</td></tr>
					<tr><td>secretary</td><td>Secretary</td><td> (administers lockers)</td></tr>
					<tr><td>fkafka</td><td>Librarian</td><td> (sign-in, sign-out type kiosk)</td></tr>
					<tr><td>sfreud</td><td>Student Success and Resource teacher</td><td> (sign-in, sign-out type kiosk)</td></tr>
					<tr><td>acheckov</td><td>runs Chess club</td><td> (attendance only kiosk)</td></tr>
					<tr><td>kkain</td><td>dance teacher</td><td> (event type kiosk)</td></tr>
					<tr class="table-warning"><td colspan=3">All of the passwords are still the default password ("<b>FloralCanoe</b>")</td><tr>
					<tr class="table-danger"><td colspan=3">The database will be restored every Sunday and Wednesday at 1am.</td><tr>
					</tbody>
					</table>
				</div>
				</div>
			@endif

		</div>

<!-- Scripts -->
@stack('scripts')

</body>
</html>

