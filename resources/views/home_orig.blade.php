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
            <li><a href="/students/339654014">Go to Student show page</a></li>
            <li><a href="/courses">Debug Course stuff</a></li>
            <li><a href="/home1">Go to AdminLTE home page</a></li>
            <li><a href="/bpterminal/1"> Launch BluePanel terminal</a></li>
            
            
        </ul>
    </div>
    <a href="http://localhost:4080/phpmyadmin/" target="_blank">start phpMyAdmin</a>
<hr style="color:black; background-color:navy;">
    <div class="box">
	<h1>Things to ask Ethan</h1>
    1. How to link to CSS and JS files<br>
    2. How to make foreign keys (e.g. for log table)<br>

	</p>
    </div>
<hr style="background-color:navy;">
** Make an Admin have an 'enable remote access' to SSH -r to AWS. If other schools want to use this then I can administer it remotely.
</div>
@endsection
