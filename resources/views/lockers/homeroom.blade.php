@extends('layouts.app') 
@section('content') 
{{--
	<ol class="breadcrumb">
	    <li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	    <li class="active"> Kiosks List</li>
	</ol> 
--}} 

<div class="container">
    <h1>Homeroom Locker Entry</h1>
    <div class="card card-info">
        <div class="card-body">
        <h3>{{ $coursecode }}</h3>
             @if($studentList->count())
            
                <div class="row my-1" style="border-bottom:solid black 1px;">
                <div class="col-md-4"><b>Student</b></div>
                <div class="col-md-1"><b>Locker#</b></div>
                <div class="col "><b>Combination #</b></div>
                </div>

                @foreach($studentList as $SL)            
                {{-- start one row of data --}}
                    <form role="form" action="/lockers/{{$SL->studentID}}" method="post">
                @if ($loop->iteration %2 == 0)
                    <div class="row py-1" style="background-color:#DDD;">
                 @else 
                    <div class="row py-1">
                @endif
                    <div class="col-md-4">
                    <span style="color:#600;">{{$loop->iteration }}.</span>&nbsp;&nbsp;{{$SL->studentID}} : {{$SL->lastname}}, {{$SL->firstname}}         
                    </div>
                    <div class="col-md-1"> <input type="text" maxlength="5" size=5 class="" id="name" name="name"> </div>                        
                    <div class="col"> <input type="text" class="" id="name" name="name"> </div>                        
                    <div class="col">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" onclick="validateForm()">Submit</button>
                        </div>
                    </div>
                </div>
                    </form>
                @endforeach 



            @endif
        </div>
    </div>
</div>    
@endsection
