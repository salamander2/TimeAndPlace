{{-- This is a modified version of HOME.BLADE.PHP -- but for only one kiosk and show all the students --}}

@extends('layouts.app')

 @section('content-header')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h4 class="m-0 text-dark">All students currently signed in to:</h4>
        </div>
      </div>
    </div>
  </div>
@endsection 

@section('content')
    <div class="container-fluid">

      <div class="card card-success">
        <div class="card-header">
          <h4 class="m-0">{{$kiosk->name }}</h4>
        </div>       
            
            <div class="card-body" style="padding:0;">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>Student Number</th>
                        <th>Student Name</th>                        
                        <th>TimeStamp</th>
                    </tr>
                    {{-- @foreach($kiosk->signedIn->sortBy('lastname') as $student) --}}
                    @foreach($kiosk->signedIn->sortBy('pivot.created_at') as $student)
                        <tr>
                            <td>{{$student->studentID}}</td>
                            
                            <td>{{$student->lastname}}, {{$student->firstname}}</td>
                            <td>{{$student->pivot->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection





