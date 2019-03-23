@extends('layouts.app') 
@section('content')
<div class="container">
    <h1>
        Create a new Kiosk
    </h1>
    <div class="col-lg-12">

        <div class="card card-primary">
            <div class="card-body">
                <form role="form" action="/kiosks" method="post">

                    <div class="form-group">
                        <label for="name">Group / Team Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        <label for="room">Room Number / Location</label>
                        <input type="text" class="form-control" id="room" name="room" value="{{ old('room') }}" required>
                        <br><br>
                        <!-- all checkboxes -->
                        <div class="callout callout-info">

                            

                            <div class="row my-1">
                                <div class="col-md-auto">
                                    <input type="checkbox" id="publicViewable" name="publicViewable">
                                </div>
                                <div class="col-md-2 bg-primary"><label for="publicViewable">Publically Viewable</label></div>
                                <div class="col border ">Kiosk logs are viewable by any logged in user</div>
                            </div>
                            <!-- end row -->
                            <div class="row my-1">
                                <div class="col-md-auto">
                                    <input type="checkbox" id="signInOnly" name="signInOnly">
                                </div>
                                <div class="col-md-2 bg-primary"><label for="signInOnly">Sign in only</label></div>
                                <div class="col border text-danger">If checked, then student is only marked present. There is no signout.<br>
                                    <b>Changing this will probably invalidate the existing logged data for this kiosk.</b></div>
                            </div>
                            <!-- end row -->

                            <div class="row my-1">
                                <div class="col-md-auto">
                                    <input type="checkbox" id="autoSignout" name="autoSignout">
                                </div>
                                <div class="col-md-2 bg-primary"><label for="autoSignout">Auto Signout</label></div>
                                <div class="col border"> If checked, then times can be entered for system to automatically sign students out.<br>                                    This has no effect if "signin only" is checked.</div>
                            </div>
                            <!-- end row -->
                        </div>
                </div>

                    <div class="callout callout-info">                          
                            
                            <div class="row my-1">
                                <div class="col-md-auto">
                                    <input type="checkbox" id="requireConf" name="requireConf">
                                </div>
                                <div class="col-md-2 bg-primary"><label for="requireConf">Require Confirmation</label></div>
                                <div class="col border ">Require a seperate confirmation step upon sign-in.</div>
                            </div>
                            <!-- end row -->
    
                            <div class="row my-1">
                                <div class="col-md-auto">
                                        <input type="checkbox" id="showPhoto" name="showPhoto">
                                </div>
                                <div class="col-md-2 bg-primary"><label for="showPhoto">Show Photo</label></div>
                                <div class="col border ">Display student photo upon sign-in</div>
                            </div>
                            <!-- end row -->
    
                            <div class="row my-1">
                                <div class="col-md-auto">
                                        <input type="checkbox" id="showSchedule" name="showSchedule">
                                </div>
                                <div class="col-md-2 bg-primary"><label for="showSchedule">Show Schedule</label></div>
                                <div class="col border">Show student schedule upon sign-in</div>
                            </div>
                            <!-- end row -->
    
                        </div>
                        <!-- end callout -->

                    <!---******* ERROR HANDLING ********** -->
                    <!-- This prints a 1 (for true) if there is an error in the name -->
                    {{-- $errors->has('name') --}}

                    <!-- this prints out all of the errors -->
                    @foreach ($errors -> all() as $error) {{ $error }} @endforeach
                    <br>
                    <!-- this prints out any errors, split up by fields. You can add formatting inside the @ IF so that it only 
                shows up when there are errors -->
                    @if ($errors->any()) {{-- dd($errors) --}} {{ $errors->first('name') }}<br> {{ $errors->first('room')
                    }} @endif

                    <div class="box-footer">
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary">Create</button> &nbsp;&nbsp;&nbsp;
                        <a href="/home" class="btn btn-success">Cancel</a>
                    </div>
                </form>
                <!-- form end -->
            </div>

        </div>
    </div>

</div>
@endsection