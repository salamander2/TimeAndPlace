@extends('layouts.app') 
@section('content')
<div class="container">
    <h1>
        Create a new Event for Kiosk "{{$kiosk->name}}"
    </h1>
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <form role="form" action="/events" method="post">                                        
                    <input type="hidden" id="kioskID" name="kioskID" value="{{$kiosk->id}}">
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="input-group">
                                <label class="input-group-prepend btn btn-success" for="name">Name </label>                            
                                <input type="text" class="form-control border border-success" id="name" name="name" value="{{ old('name') }}" required autofocus>

                            </div>
                            (eg. 7AM Rehearsal)
                        </div> <!-- end row -->
                        <div class="row py-3">
                            <div class="col-sm-2">
                                <label class="input-group-prepend btn btn-info" for="date">Date </label>
                                <input type="date" class="form-control border border-info" id="date" name="date" value="{{ old('date') }}" required>
                            </div>
                            <div class="col-sm-2">
                                <label class="input-group-prepend btn btn-info" for="startTime">Start Time </label>
                                <input type="time" class="form-control border border-info" id="startTime" name="startTime" value="{{ old('startTime') }}" required>
                            </div>
                            <div class="col-sm-2">
                                <label class="input-group-prepend btn btn-info" for="lateTime">Late Time </label>
                                <input type="time" class="form-control border border-info" id="lateTime" name="lateTime" value="{{ old('lateTime') }}" required>
                            </div>
                            <div class="col-sm-2">
                                <label class="input-group-prepend btn btn-info" for="endTime">End Time </label>
                                <input type="time" class="form-control border border-info" id="endTime" name="endTime" value="{{ old('endTime') }}" required>
                            </div>
                            
                        </div> <!-- end row -->
                        <div class="row py-1">
                        <p><b>Date:</b> the date of the event<br>
                            <b>Start Time:</b> students cannot log in before this time (because there might be an earlier event on the same day)<br>
                            <b>Late Time:</b> after this time, students are considered late<br>
                            <b>End Time:</b> students cannot log in past this time</p>
                        </div> <!-- end row -->
                        <div class="card-footer">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary">Create</button> &nbsp;&nbsp;&nbsp;
                                <a href="/kiosks/{{$kiosk->id}}/edit" class="btn btn-success">Cancel</a>
                            </div>
                        </form>
                        <!-- form end -->
            </div>
        </div>
    </div>
</div>
@endsection