<div class="card card-dark collapsed-card">
    <div class="card-header" data-widget="collapse">
        {{-- KIOSK SETTINGS : top part of Kiosk Edit page --}}
        <h3 class="card-title">Kiosk Settings</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" xxxdata-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">


        <!-- form start -->
        <form role="form" action="/kiosks/{{ $kiosk->id }}" method="post">
            {{ method_field('PATCH') }}            
                <div class="form-group">

                    <div class="input-group mb-3">
                        <label class="col-md-3 input-group-prepend btn btn-success" for="name">Group / Team Name</label>
                        <input type="text" class="col form-control border border-success" id="name" name="name" value="{{ $kiosk->name }}">
                    </div>
                    <div class="input-group mb-3">
                        <label class="col-md-3 input-group-prepend btn btn-success" for="room">Room Number / Location</label>
                        <input type="text" class="col form-control border border-success" id="room" name="room" value="{{ $kiosk->room}}">
                    </div>

                    <h3>Kiosk Type</h3>
                    @php
                       $kskType = $kiosk->kioskType;  
                    @endphp
                    <div class="callout callout-danger bg-secondary">
                      
                        <div class="row my-1">
                            <div class="col-md-3">
                                    @switch($kskType)
                                    @case(0)
                                        <div class="alert alert-warning"><b>Sign in/ Sign out</b></div>
                                        @break
                                    @case(1)
                                        <div class="alert"><h4>Attendance Only</h4></div>
                                        @break
                                    @case(2)
                                        <p>Events with present/late/absent</p>
                                @endswitch
                            </div>
                            @switch($kskType)
                            @case(0)
                                <div class="col border alert text-danger">
                                    Sign in and sign out times are recorded.
                                </div>
                                @break
                            @case(1)
                                <div class="col alert my-0 text-dark">
                                    <b>Attendance recorded for meetings, teams, clubs, etc.<br>
                                    No logs, just reports.</b>
                                </div>
                                @break
                            @case(2)
                                <div class="col alert text-dark">
                                    <b>(write something about events)</b>
                                </div>
                                @break
                            @endswitch
                        </div>
                        <!-- end row -->

                        @if($kskType==0)
                            <div class="row my-1">
                                <div class="col-md-auto">
                                    <input type="checkbox" id="autoSignout" name="autoSignout" {{ $kiosk->autoSignout ? 'checked':''}}>
                                </div>
                                <div class="col-md-2 bg-warning"><label for="autoSignout">Auto Signout</label></div>
                                <div class="col border"> If checked, then times can be entered for system to automatically sign students out.<br>
                                    e.g. at the end of a period.</div>
                            </div>
                            <!-- end row -->
                        @endif

                    </div>

                    <h3>Options</h3>
                    <div class="callout callout-info">

                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="publicViewable" name="publicViewable" {{ $kiosk->publicViewable ? 'checked' :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="publicViewable">Publically Viewable</label></div>
                            <div class="col border ">Kiosk logs are viewable by any logged in user</div>
                        </div>
                            <!-- end row -->
                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="requireConf" name="requireConf" {{ $kiosk->requireConf ? 'checked'
                                :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="requireConf">Require Confirmation</label></div>
                            <div class="col border ">Require a seperate confirmation step upon <b>sign-in.</b></div>
                        </div>
                        <!-- end row -->

                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="swalOKbtn" name="swalOKbtn" {{ $kiosk->swalOKbtn ? 'checked'
                                :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="swalOKbtn">Display OK button</label></div>
                            <div class="col border ">OK button for <b>sign-in</b> can be clicked instead of waiting for the alert to disappear.</div>
                        </div>
                        <!-- end row -->

                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="showPhoto" name="showPhoto" {{ $kiosk->showPhoto ? 'checked' :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="showPhoto">Show Photo</label></div>
                            <div class="col border ">Display student photo upon <b>sign-in</b></div>
                        </div>
                        <!-- end row -->

                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="showSchedule" name="showSchedule" {{ $kiosk->showSchedule ? 'checked'
                                :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="showSchedule">Show Schedule</label></div>
                            <div class="col border">Show student schedule upon <b>sign-in</b> (not implemented yet)</div>
                        </div>
                        <!-- end row -->

                    </div>
                    <!-- end callout -->
                </div>
                <div class="box-footer">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-warning elevation-3">Update</button>
                    <span style="float:right">
                        Terminal login URL: &rArr; <code><span style="background-color:#EEE;color:#AAA">
                        <script>document.write(window.location.origin);</script>/terminalAuth/{{$kiosk->secretURL }} </span></code> &lArr;<br>
                    Copy the url and paste it into the browser in order to start the terminal for this kiosk without having to login first.</span>
                </div>
            
        </form>
        <!-- form end -->
       
    </div>
    <!-- /.card-body -->
</div>
<!-- end card -->

