<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        
    @include('layouts.headLinks')

    @stack('styles')
</head>
<body class="hold-transition login-page">
        
          
<body class="hold-transition skin-blue fixed sidebar-mini">
    
    <div class="login-box bg-primary border border-dark rounded">
        <div class="login-logo">
            <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" 
            class="brand-image img-circle elevation-3 my-3" style="opacity: .8">
            <span class="brand-text font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
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
        </div>
    </div>
</div>
</section>
</div>
</div>

<!-- Scripts -->
@stack('scripts')

</body>
</html>

