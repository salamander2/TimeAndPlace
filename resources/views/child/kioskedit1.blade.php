<div class="card card-dark">
    <div class="card-header">
        {{-- KIOSK SETTINGS : top part of Kiosk Edit page --}}
        <h3 class="card-title">Kiosk Settings</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">


        <!-- form start -->
        <form role="form" action="/kiosks/{{ $kiosk->id }}" method="post">
            {{ method_field('PATCH') }}            
                <div class="form-group">

                    <div class="input-group mb-3">
                        <label class="input-group-prepend btn btn-success" for="name">Group / Team Name</label>
                        <input type="text" class="form-control border border-success" id="name" name="name" value="{{ $kiosk->name }}">
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-prepend btn btn-success" for="room">Room Number / Location</label>
                        <input type="text" class="form-control border border-success" id="room" name="room" value="{{ $kiosk->room}}">
                    </div>

                    <div class="callout callout-info">
                        <!-- all checkboxes -->
                      
                        <div class="row my-1">
                            <div class="col-md-2">
                            
{{-- <input type="checkbox" id="signInOnly" name="signInOnly" {{ $kiosk->signInOnly ? 'checked' :''}}> --}}
                                    <!-- Group of default radios - option 1 -->
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" id="defaultGroupExample1" name="signInOnly" {{ $kiosk->signInOnly ? '':'checked'}}  type="radio">
                                      <label class="custom-control-label text-primary" for="defaultGroupExample1">&nbsp;Sign In/Out</label>
                                    </div>
                            
                                   
                                    <!-- Group of default radios - option 2 -->
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" id="defaultGroupExample2" name="signInOnly" {{ $kiosk->signInOnly ? 'checked':''}} type="radio">
                                      <label class="custom-control-label text-primary" for="defaultGroupExample2">&nbsp;Present Only</label>
                                    </div>
                            
                                   
                                </div>

           
                            <div class="col border text-danger">If checked, then student is only marked present. There is no signout.<br>
                                <b>Changing this will probably invalidate the existing logged data for this kiosk.</b></div>
                        </div>
                        <!-- end row -->

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
                                <input type="checkbox" id="autoSignout" name="autoSignout" {{ $kiosk->autoSignout ? 'checked':''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="autoSignout">Auto Signout</label></div>
                            <div class="col border"> If checked, then times can be entered for system to automatically sign students out.<br> This
                                has no effect if "signin only" is checked.</div>
                        </div>
                        <!-- end row -->


                    </div>

                    <div class="callout callout-info">

                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="requireConf" name="requireConf" {{ $kiosk->requireConf ? 'checked'
                                :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="requireConf">Require Confirmation</label></div>
                            <div class="col border ">Require a seperate confirmation step upon sign-in.</div>
                        </div>
                        <!-- end row -->

                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="showPhoto" name="showPhoto" {{ $kiosk->showPhoto ? 'checked' :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="showPhoto">Show Photo</label></div>
                            <div class="col border ">Display student photo upon sign-in</div>
                        </div>
                        <!-- end row -->

                        <div class="row my-1">
                            <div class="col-md-auto">
                                <input type="checkbox" id="showSchedule" name="showSchedule" {{ $kiosk->showSchedule ? 'checked'
                                :''}}>
                            </div>
                            <div class="col-md-2 bg-primary"><label for="showSchedule">Show Schedule</label></div>
                            <div class="col border">Show student schedule upon sign-in</div>
                        </div>
                        <!-- end row -->

                    </div>
                    <!-- end callout -->
                </div>
                <div class="box-footer">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-warning elevation-3">Update</button>
                </div>
            
        </form>
        <!-- form end -->
    </div>
    <!-- /.card-body -->
</div>
<!-- end card -->

