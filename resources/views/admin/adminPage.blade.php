@extends('layouts.app')
@section('content')
<div class="container"><div class="container-fluid">
    <h1>
        Database Admininstration Page
    </h1>

    <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="" class="nav-link">
            <div class="info-box bg-warning">
              <span class="info-box-icon"><i class="fa fa-bezier-curve"></i></span>
              <div class="info-box-content">
                <h3 class="info-box-text">User<br>Maintenance</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div> <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">
            <a href="" class="nav-link">
            <div class="info-box bg-info">
              <span class="info-box-icon"><i class="fas fa-school"></i></span>
              <div class="info-box-content">
                <h3 class="info-box-text">Create a<br>new Kiosk</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <a href="http://localhost:4080/phpmyadmin" target="_blank" class="nav-link">
            <div class="info-box bg-success">
              <span class="info-box-icon"><i class="fas fa-indent"></i></span>
              <div class="info-box-content">
                <h3 class="info-box-text">Go to<br>phpMyAdmin</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->


          <div class="col-md-3 col-sm-6 col-12">
            <a href="http://localhost:4080/phpmyadmin" target="_blank" class="nav-link">
            <div class="info-box bg-danger">
              <span class="info-box-icon"><i class="fas fa-comments"></i></span>

              <div class="info-box-content">
                <h3 class="info-box-text">Auto signout<br>everyone now</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

    <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="" class="nav-link">
            <div class="info-box btn btn-outline-secondary text-dark">
              <span class="info-box-icon"><i class="fa fa-book"></i></span>
              <div class="info-box-content">
                <h3 class="info-box-text">Load<br>Markbook</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div> <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">

            <div class="card collapsed-card card-warning">
              <div class="card-header">
                  <h3 class="card-title">Load new<br>teacher schedule</h3>

                  <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-plus"></i></button>
                  </div><!-- /.card-tools -->
              </div><!-- /.card-header -->

              <div class="card-body">
                 The format for this file needs to be ... ... ...<br>
                 `:warning
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
          </div> <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">
          <form method="POST" action="/delGrads" enctype="multipart/form-data">
						@csrf
            <div class="info-box btn btn-danger text-dark">
              <span class="info-box-icon"><i class="fas fa-indent"></i></span><br>
              <div class="info-box-content">
                <h3 class="info-box-text">Delete all<br>old students</h3>
                  <input type="file" name="fileupload" value="fileupload" id="fileupload"  accept="text/plain"><br>
                  <label for="fileupload"> Select Markbook file to upload</label><br>
                 <button type="submit" class="btn btn-primary">Go</button>
              </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
            </form>
            <p>Only do this in September</p>

          </div><!-- /.col -->


          <div class="col-md-3 col-sm-6 col-12">
            <a href="http://localhost:4080/phpmyadmin" class="nav-link">
            <div class="info-box bg-secondary">

              <div class="info-box-content">
                <h3 class="info-box-text">Set Assembly<br>Day schedule</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->


    <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <a href="" class="nav-link">
            <div class="info-box bg-warning">
              <span class="info-box-icon"><i class="fa fa-bezier-curve"></i></span>
              <div class="info-box-content">
                <h3 class="info-box-text">User<br>Maintenance</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div> <!-- /.col -->

          <div class="col-md-3 col-sm-6 col-12">
            <a href="" class="nav-link">
            <div class="info-box btn btn-outline-info">
              <span class="info-box-icon"><i class="fas fa-school"></i></span>
              <div class="info-box-content">
                <h3 class="info-box-text">Create a<br>new Kiosk</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <a href="http://localhost:4080/phpmyadmin" target="_blank" class="nav-link">
            <div class="info-box bg-success">
              <span class="info-box-icon"><i class="fas fa-indent"></i></span>
              <div class="info-box-content">
                <h3 class="info-box-text">Go to<br>phpMyAdmin</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </a>
          </div>
          <!-- /.col -->


          <div class="col-md-3 col-sm-6 col-12">
            <a href="http://localhost:4080/phpmyadmin" target="_blank" class="nav-link">
            <div class="info-box bg-danger">
              <span class="info-box-icon"><i class="fas fa-comments"></i></span>

              <div class="info-box-content">
                <h3 class="info-box-text">Auto signout<br>everyone now</h3>
              </div>
              <!-- /.info-box-content -->
            </div>
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
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>

                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                  70% Increase in 30 Days
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
--}}
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
               First Item
               <form action="">
                  <input type="file" name="fileupload" value="fileupload" id="fileupload"  accept="text/plain">
                  <label for="fileupload"> Select Markbook file to upload</label>
                  <input type="submit" value="submit">
                </form>

{{--
Accessing via JavaScript:
<input type="file" id="input" onchange="handleFiles(this.files)">
OR
var fileData = $('#input-file').prop('files')[0];
SEE https://developer.mozilla.org/en-US/docs/Web/API/File/Using_files_from_web_applications
https://stackoverflow.com/questions/12281775/get-data-from-file-input-in-jquery
--}}
            </div>

        </div>
    </div>

</div></div>
@endsection
