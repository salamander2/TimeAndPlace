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
                    <input type="text" class="form-control" id="name" name="name" value= "{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="is-invalid" role="alert">
                            <strong>{{ $errors->first('name') }}</strong><br>
                        </span>
                    @endif
                    <label for="room">Room Number / Location</label>
                    <input type="text" class="form-control" id="room" name="room" value= "{{ old('room') }}">
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
            @if($errors-> any())
                <div class="notification is-danger">
                    <ul>
                        @foreach ($errors->all() as $error) 
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            
            <!-- /.box-body -->

            <div class="box-footer">
                {{csrf_field()}}
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection