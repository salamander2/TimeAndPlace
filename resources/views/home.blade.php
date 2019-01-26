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
            
        </ul>
    </div>
    <a href="http://localhost:4080/phpmyadmin/" target="_blank">start phpMyAdmin</a>
</div>
@endsection
