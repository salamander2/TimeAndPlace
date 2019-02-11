@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Main page after logging in</h2>
    <div class="row justify-content-center">

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif


    </div>
    <div class="title m-b-md">
        Laravel
    </div>
    <div class="links">
        <ul>
            <li><a href="/userMaint">UserMaint: List users</a></li>
            <li><a href="/kiosks">List all Kisoks</a></li>
            <li><a href="/students">Go to Student index page</a></li>
            <li><a href="/students/1">Go to Student show page</a></li>
            <li><a href="/students2">Debug Course stuff</a></li>
            <li><a href="/home2">Go to AdminLTE home page</a></li>
            
            
        </ul>
    </div>
    <a href="http://localhost:4080/phpmyadmin/" target="_blank">start phpMyAdmin</a>
<hr style="color:black; background-color:navy;">
    <div class="box">
	<h1>Things to ask Ethan</h1>
	<p>1. How to compile SASS<br>
	2. 'npm run watch' does now work, neither does 'npm run prod' or 'npm run dev'<br>
	3. How to install SweetAlert?<br>
	4. How to link to CSS and JS files<br>

	</p>
    </div>
<hr style="background-color:navy;">
** Make an Admin have an 'enable remote access' to SSH -r to AWS. If other schools want to use this then I can administer it remotely.
</div>
@endsection
