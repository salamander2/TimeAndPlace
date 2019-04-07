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
      <h5>Version# <span class="badge badge-light "> 1.0</span><br>
	<?php $branch = exec('git rev-parse --abbrev-ref HEAD'); echo "<p>(".$branch." branch)</p>"; ?>
      </h5>
    </div>
    <div class="p-3">
        <p>1.1 Terminal sign in/out using loginID/studentID.<br>Kiosk deletion fixed. (20190407)</p>
        <p>1.0 Initial release (20190329)</p>
    </div>

  </aside>
  <!-- /.control-sidebar -->
