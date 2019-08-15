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
    <div class="p-3 bg-info">
      <h5>VERSION # <span class="badge badge-light "> {{env('VERSION') }}</span><br><br>
	<?php $branch = exec('git rev-parse --abbrev-ref HEAD'); echo "<p>(<u>".$branch."</u> branch)</p>"; ?>
      </h5>
    </div>
    
     
    <div class="card-body">
	    <a href="/students" class="btn btn-outline-info">List all Students</a>
		  <a href="/students/339654014" class="btn btn-outline-info">Go to Student show page</a>
      <a href="/courses" class="btn btn-outline-info">List Courses</a>
      <a href="/testing/13" class="btn btn-outline-info">Testing Laravel</a>
    </div>
    
  </aside>
  <!-- /.control-sidebar -->
