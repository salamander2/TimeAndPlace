@extends('layouts.app') 
@section('content')
<div class="container">
    <h2>Displaying Student Data</h2>
    <div class="row justify-content-center">

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif 
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        

    </div>

    <div id="main">
            <div id="main-top">
                <h1 class="centered">{{$record->lastname}}, {{$record->firstname}} </h1>
            
            <!-- **************** Begin insert photo ***************** -->
                <a href="{{$photoURL}}">
                    <img class="student-img" src="{{ $photoURL }}" width="170" height="200">
                </a>
            <!-- end insert photo. ** This cannot retrieve the photo from ~benson: 
                <img class="student-img" src="/~benson/photos/user_blank.png">
            -->
            
            <!-- **************** Begin markbook section [left box in main-top section] ***************** -->
            <div class="box2">       
            <div id="mkbk">
            <p style="border:1px solid gray;padding:2px 4px;">
                Student Number: <span class="white">{{ $record->studentID }}</span>
                <span class="fright">Gender: <span class="white">{{ $record->gender}}</span></span><br>
                Birthdate: <span class="white">{{ $record->dob }}</span>
                <span class="fright">Age: <span class="white">{{ $age }}</span></span>
            </p>
            <h4>Fake Time Table</h4>
            <table class="timetable">
            <tr><th>Period</th><th>Course</th><th>Teacher</th><th>Room</th></tr>
            <tr><td>1</td><td>ESLAO1-01</td><td>Corbett, Rebecca</td><td>226</td></tr><tr><td>2</td><td>PPL1OM-07</td><td>Harvey, Brian</td><td>B37</td></tr><tr><td>4</td><td>CGC1PR-03</td><td>Brown, David</td><td>207</td></tr><tr><td>5</td><td>MAT1LL-03</td><td>Orr, Amy</td><td>226</td></tr></table>
            <p class="fontONE smaller fleft gray" title="Teacher and student course codes for COOP are completely different!"><i>COOP courses won't show up here</i></p>
            </div>
    

    {{-- $record --}}

    <h4>Sample Record</h4>
    {"studentID":302808019,"firstname":"Meena","lastname":"Vyas","gender":"F","dob":"2000-04-09","timetable":"ADA4M101 CHY4U101 ENG4C105 HZT4U101"} 

 



   
</div>
@endsection
