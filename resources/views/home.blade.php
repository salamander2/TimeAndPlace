@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Main page after logging in</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
        <div class="title m-b-md">
                    Laravel
        </div>
        <div class="links">
	<ul>
	    <li><a href="https://laravel.com/docs">Admin Options</a></li>
            <li><a href="password/change">Change password</a></li>
            <li><a href="/userMaint">List users</a></li>
	</ul>
        </div>
</div>
@endsection
