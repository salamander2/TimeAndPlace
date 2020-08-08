 <!-- Control Sidebar -->
 <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3 bg-warning">
      <h5 class="text-dark">TERMINOLOGY</h5>
    </div>
    <div class="p-3">
	<p><b><u>Kiosk:</u></b> the team, club, group, department, ... that is tracking attendance</p>
	<p><b><u>Terminal:</u></b> the screen where students log in/out</p>
	<p>See help screen for more information</p>
    </div>
    <div class="p-2 bg-info">
      <p>VERSION # <span class="badge badge-light "> {{env('VERSION') }}</span><br>
	    <?php $branch = exec('git rev-parse --abbrev-ref HEAD'); echo "(<u>".$branch."</u> branch)"; ?>
      </p>
    </div>
    
    <div class="p-1 text-warning">
      <h5>Latest updates:</h5>
      <p>Markbook: <code>  
      <?php echo file_get_contents(public_path('storage/photos/markbook.date')); ?>
      </code><br>
	    Teacher Schedule: <code>
      <?php echo file_get_contents(public_path('storage/photos/timetable.date')); ?>
      </code></p>
    </div>
     
    <div class="card-body">
<<<<<<< HEAD
       <a href="/allstudents" class="my-2 btn btn-outline-info" target="_blank">List all Students</a>
       <a href="/allstudentsNoPhotos" class="my-2 btn btn-outline-info" target="_blank">Students with no photos</a>
       <a href="/allcourses" class="my-2 btn btn-outline-info" target="_blank">List Courses</a>
=======
	    <a href="/allstudents" class="my-2 btn btn-outline-info" target="_blank">List all Students</a>
      <a href="/allcourses" class="my-2 btn btn-outline-info" target="_blank">List all Courses</a>
>>>>>>> adminPanel
      {{-- <a href="/testing/13" class="my-2 btn btn-outline-info">Testing Laravel</a> --}}
    </div>
    
  </aside>
  <!-- /.control-sidebar -->
