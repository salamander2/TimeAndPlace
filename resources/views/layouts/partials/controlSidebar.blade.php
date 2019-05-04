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
    <div class="p-3">
        <p>1.2 (20190413)<br>* Schedules and autologout now working.<br></p>
        <p>1.1 (20190407)<br>* Terminal sign in/out using loginID/studentID.<br>* Kiosk deletion fixed. </p>
        <p>1.0 (20190329) Initial release </p>
    </div>
     <ul>  
	  <li><a href="/students" class="btn btn-outline-info">Go to Student index page</a></li>
		  <li><a href="/students/339654014" class="btn btn-outline-info">Go to Student show page</a></li>
      <li><a href="/courses" class="btn btn-outline-info">Debug Course stuff</a></li>
    </ul>
    <br><br><Br><br>
  </aside>
  <!-- /.control-sidebar -->
