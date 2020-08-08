@extends('layouts.app')
@section('content')
<div class="container"><div class="container-fluid">
    <h1>
        Database Admininstration Page
    </h1>

{{-- FIRST ROW --}}
    <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="userMaint" class="nav-link">
            <div class="info-box bg-warning">
              <span class="info-box-icon"><i class="fa fa-bezier-curve"></i></span>
              <div class="info-box-content">
                <h4 class="info-box-text">User<br>Maintenance</h4>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div> <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">
            <a href="/kiosks/create" class="nav-link">
            <div class="info-box bg-info">
              <span class="info-box-icon"><i class="fas fa-school"></i></span>
              <div class="info-box-content">
                <h4 class="info-box-text">Create a<br>new Kiosk</h4>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <a href="{{$phpmyadmin}}" class="nav-link" target="_blank">
            <div class="info-box bg-success">
              <span class="info-box-icon"><i class="fas fa-indent"></i></span>
              <div class="info-box-content">
                <h4 class="info-box-text">Go to<br>phpMyAdmin</h4>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->


          <div class="col-md-3 col-sm-6 col-12">
            <a href="/autosignout" onclick="return confirm('Are you sure that you want to do this?')" class="nav-link">
            <div class="info-box bg-danger">
              <span class="info-box-icon"><i class="fas fa-comments"></i></span>

              <div class="info-box-content">
                <h4 class="info-box-text">Auto signout<br>everyone now</h4>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

{{-- SECOND ROW --}}
    <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="" class="nav-link">
            <div class="info-box btn btn-outline-secondary text-dark">
              <span class="info-box-icon"><i class="fa fa-book"></i></span>
              <div class="info-box-content">
                <h4 class="info-box-text">Load<br>Markbook</h4>
                <p>Not working yet</p>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div> <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">
            <a class="nav-link"> {{-- needed for correct spacing on page --}}
            <div class="card collapsed-card card-warning">
              <div class="card-header border border-warning">
                  <h4>Load new<br>teacher schedule</h4>
                <p>Not working yet</p>
                  <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-plus"></i></button>
                  </div><!-- /.card-tools -->
              </div><!-- /.card-header -->

              <div class="card-body">
                 The format for this file needs to be ... ... ...<br>
                 warning
                <br>
                <button class="btn btn-danger">Go</button>
              </div> <!-- /.card-body -->
            </div><!-- /.card -->
            {{--
            <a href="" class="nav-link">
            <div class="info-box btn btn-outline-warning text-dark">
              <div class="info-box-content">
                <h3 class="info-box-text">Load new<br>teacher schedule</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          --}}
          </a>
          </div> <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">
             <a class="nav-link" href="delGrads">
            <div class="info-box btn btn-danger text-dark">
              <span class="info-box-icon"><i class="fas fa-indent"></i></span><br>
              <div class="info-box-content">
                <h4 class="info-box-text">Delete all<br>old students</h4>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
              </a>
          </div><!-- /.col -->


          <div class="col-md-3 col-sm-6 col-12">
            <a href="{{$phpmyadmin}}" class="nav-link">
            <div class="info-box bg-secondary">

              <div class="info-box-content">
                <h4 class="info-box-text">Set assembly<br>day schedule</h4>
                <p>Not working yet</p>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->



{{--  this is the info-box template ...
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-success">
              <span class="info-box-icon"><i class="fas fa-school"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">likes</span>
                <span class="info-box-number">41,410</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                  70% increase in 30 days
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
--}}

{{--
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
               first item
               <form action="">
                  <input type="file" name="fileupload" value="fileupload" id="fileupload"  accept="text/plain">
                  <label for="fileupload"> select markbook file to upload</label>
                  <input type="submit" value="submit">
                </form>
--}}

{{--
accessing via javascript:
<input type="file" id="input" onchange="handlefiles(this.files)">
or
var filedata = $('#input-file').prop('files')[0];
see https://developer.mozilla.org/en-us/docs/web/api/file/using_files_from_web_applications
https://stackoverflow.com/questions/12281775/get-data-from-file-input-in-jquery
--}}
            </div>

        </div>
    </div>

</div></div>
@endsection
