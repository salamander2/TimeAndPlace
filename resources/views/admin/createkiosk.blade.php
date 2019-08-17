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
                        <div class="row">
                        <div class="input-group mb-3">
                            <label class="input-group-prepend btn btn-success" for="name">Group / Team Name</label>                            
                            <input type="text" class="form-control border border-success" id="name" name="name" value="{{ old('name') }}" required autofocus>
                        </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-3">
                                <label class="input-group-prepend btn btn-success" for="room">Room Number / Location</label>                            
                                <input type="text" class="form-control border border-success" id="room" name="room" value="{{ old('room') }}" required>
                            </div>
                        </div>
                        <!-- all checkboxes -->                
                            <div class="row my-1">
                                <div class="col-md-3 alert alert-primary border-primary" >    
                                    <!-- Group of default radios - option 1 -->                                    
                                        <input id="defaultGroupExample1" name="kioskType" type="radio" value="no">
                                        <label for="defaultGroupExample1">&nbsp;Sign In/Out</label>
                                        <br>
                                    <!-- Group of default radios - option 2 -->                                        
                                        <input  id="defaultGroupExample2" name="kioskType"  type="radio" value="yes">
                                        <label  for="defaultGroupExample2">&nbsp;Present Only</label>
                                </div>
               
                                <div class="col alert border-primary text-danger">
                                    <b>Sign in/out: The sign in and sign-out times are recorded for the student. </b><br>
                                    <b>Present: There is no sign-out. This is just to tell if a student is present at a meeting/club/event on a given day. 
                                        (Date and time are recorded)</b>
                                </div>
                                <p class="text-danger" style="margin-top:-10px;">This setting cannot be changed later on. The kiosk must be deleted and recreated (otherwise the stored data would be invalidated)</p>
                            </div>
                            <!-- end row -->
    

                            <div class="row my-1">
                                <div class="col-md-3 alert alert-primary border-primary">
                                    <input type="checkbox" id="publicViewable" name="publicViewable">
                                    <label for="publicViewable">Publically Viewable</label>
                                </div>                                
                                <div class="col alert border-primary">Kiosk logs are viewable by any logged in user (ie. any teacher).<br>
                                Otherwise, the logs are only viewable by kiosk users listed.</div>
                            </div>                            
                            <!-- end row -->

                            <div class="row my-1">
                                    <div class="col-md-3 alert alert-primary border-primary">
                                        <input type="checkbox" id="autoSignout" name="autoSignout">
                                        <label for="autoSignout">Auto Signout</label>
                                    </div>                                
                                    <div class="col alert border-primary "> If checked, then times can be entered for system to automatically sign students out.<br>
                                        This has no effect if "Present Only" is selected above.</div>
                                </div>                            
                                <!-- end row -->

                        
                </div>

{{--  The following section has been moved to EDIT KIOSK
                    <div class="callout callout-success">                          
                            
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
                          --}}

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

                    {{--  <div class="card-footer bg-secondary">  --}}
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-primary">Create</button> &nbsp;&nbsp;&nbsp;
                        <a href="/home" class="btn btn-success">Cancel</a>
                    {{--  </div>  --}}
                </form>
                <!-- form end -->
            </div>

        </div>
    </div>

</div>
@endsection
