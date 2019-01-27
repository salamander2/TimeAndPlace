@extends('layouts.app') 
@section('content-header')
<h1>
    Create Kiosk
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
    <li class="active">Create Kiosk</li>
</ol>
@endsection
@section('content')
<div class="col-lg-6">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Create a new Kiosk</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/addKiosk" method="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Group / Team Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    <label for="room">Room Number / Location</label>
                    <input type="text" class="form-control" id="room" name="room" value="{{ old('room') }}" required>
                    <!-- all checkboxes -->
                    <label for="showPhoto">Show Photo</label>                    
                    <input type="checkbox" id="showPhoto" name="showPhoto">
                    <label for="showSchedule">Show Schedule</label>                    
                    <input type="checkbox" id="showSchedule" name="showSchedule">
                    <label for="requireConf">Require Confirmation</label>                    
                    <input type="checkbox" id="requireConf" name="requireConf">
                    <label for="publicViewable">Publically Viewable</label>                    
                    <input type="checkbox" id="publicViewable" name="publicViewable">
                    <label for="signInOnly">Sign in only</label>                    
                    <input type="checkbox" id="signInOnly" name="signInOnly">
                    <label for="autoSignout">Auto Signout</label>                    
                    <input type="checkbox" id="autoSignout" name="autoSignout">
                    
                    
                </div>
                <div class="form-group">
                        <label for="adminName">Admin / users?</label>
                        <input type="text" class="form-control" id="adminName" name="adminName">
                </div>

            </div>


            <!-- /.box-body -->
            <!---******* ERROR HANDLING ********** -->
            <!-- This prints a 1 (for true) if there is an error in the name -->
                {{-- $errors->has('name') --}} 
        
            <!-- this prints out all of the errors -->
            @foreach ($errors -> all() as $error)
                {{ $error }}
            @endforeach                             	
        
            <!-- this prints out any errors, split up by fields. You can add formatting inside the @ IF so that it only 
                shows up when there are errors -->
            @if ($errors->any())
                {{-- dd($errors) --}}
                
                {{ $errors->first('name') }}<br>                
                {{ $errors->first('room') }}
            @endif

            <div class="box-footer">
                {{csrf_field()}}
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
        <!-- form end -->
    </div>
</div>
@endsection