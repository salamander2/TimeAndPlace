@extends('layouts.app') 

@push('styles')
<style>
.timetable {
   margin-top:0.8em;
   border:1px solid gray;
}
.timetable td, .timetable th
{
   padding-left:8px;
   padding-right:8px;
   border-left:1px solid gray;
   border-right:1px solid gray;
   text-align:center;
}
.timetable th {
   border-bottom:1px solid gray;
}
.timetable td + td,
.timetable th + th
{
    text-align:left;
}

</style>
@endpush

@section('content')

<div class="container">

{{--  what is this for???
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
--}}
    <div class="card card-info">
    <div class="card-body">
        <div class="float-right"> 
        <a href="/logs/byStudent/{{$student->studentID}}"><button class="elevation-3 btn btn-warning">Logs</button></a>
        </div>
        <h1 class="centered">{{$student->lastname}}, {{$student->firstname}} </h1>
      <div class="row"> 
        <div class="col-md-auto">
        <!-- **************** Begin insert photo ***************** -->
            <a href="{{$photoURL}}">
                <img class="rounded"  src="{{ $photoURL }}" width="180" height="225">
            </a>
        <!-- end insert photo. ** This cannot retrieve the photo from ~benson: 
            <img class="student-img" src="/~benson/photos/user_blank.png">
        -->
        </div>
        <div class="col-md-auto px-3 py-3 rounded bg-secondary">
            <table>
            <tr><td>
                <b style="color:black;">Student Number:</b> {{ $student->studentID }}
            </td></tr>
            <tr><td>
                <b style="color:black;">Gender:</b> {{ $student->gender}} &nbsp;&nbsp; <b style="color:black;">Age:</b> {{ $age }}
            </td></tr>
            <tr><td>
                <b style="color:black;">Birthdate:</b> {{ $student->dob }}
            </td></tr>
            <tr><td>
            <b style="color:black;">Guardian Phone:</b> {{$student->guardianPhone}}<br>
            <b style="color:black;">Guardian Email:</b> {{$student->guardianEmail}}
            </td></tr>
            <tr><td>
            <b style="color:black;">Login:</b> {{ $student->loginID }}
            </td></tr>
            </table>
        </div>
      </div>

       <div class="rounded alert border-primary my-3 p-2">
            <h4 class="text-primary">Time Table</h4>
            <div class="col-auto">
                <table class="timetable">
                <tr><th>Period</th><th>Course</th><th>Teacher</th><th>Room</th></tr>
                @foreach ($courses as $c)
                    <tr><td>{{$c->period}}</td><td>{{$c->coursecode}}</td><td>{{$c->teacher}}</td><td>{{$c->room}}</td></tr>
                @endforeach
                </table>
                <p class="fontONE smaller fleft gray" title="Teacher and student course codes for COOP are completely different!"><i>COOP courses won't show up here</i></p>
            </div>
        </div>

        <div class="rounded card border-success p-2">
        <h4 class="text-success">Locker Info</h4>
        <div class="col-md-auto">
            @foreach($lockerArray as $oneLocker)
                @if (auth()->check() && auth()->user()->username == 'secretary' || auth()->user()->isAdministrator())
                    <b>Locker number:</b> <a href="/lockers/edit/{{$oneLocker['0']}}">{{$oneLocker['0']}}</a><br>
                    <kbd><b>Combination:</b> {{$oneLocker['1']}}</kbd><br>
                @else
                    <b>Locker number:</b> {{$oneLocker['0']}}<br>
                @endif

                @if(count($oneLocker['2']))
                    This locker is shared with:
                    @foreach ($oneLocker['2'] as $x)
                    {{$x}};  
                    @endforeach
                @endif
                <br>
            @endforeach
        </div>
        </div>
    </div>
    </div>

   
</div>
@endsection
