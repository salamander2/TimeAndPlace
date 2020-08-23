@extends('layouts.app')



@section('content-header')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Help &amp; Information</h1>
			</div>
		</div>
	</div>
</div>
@endsection



@section('content')

<div class="row">
	<div class="col-12">
		<!-- Custom Tabs -->
		<div class="card">
			<div class="card-header d-flex p-0">
				<ul class="nav nav-pills p-2">
					<li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Overview</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">User Roles</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_3" data-toggle="tab">Terminal Screen</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_4" data-toggle="tab">Kiosk Settings</a></li>
					<li class="nav-item"><a class="nav-link" href="#tab_5" data-toggle="tab">Reports</a></li>
				</ul>
			</div><!-- /.card-header -->
			<div class="card-body">
				<div class="tab-content">

					<div class="tab-pane active" id="tab_1">

						<div class="card card-warning">
							<div class="card-header">
								<h4>Terminology</h4>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="card-body">
								<h5><b><u>Kiosk:</u></b> the team, club, group, department, ... that is tracking attendance.
									Because this is program flexible enough to encompass all of these different
									groups/teams/classes/categories, "kiosk" is being used as the general term for them all.
								</h5>
								<h5><b><u>Terminal:</u></b> the screen that is used for students to log in and log out. </h5>
								<h5><i class="icon fa fa-star"></i> The Home screen shows the students who are currently signed in to
									all the public kiosks</h5>
							</div>
						</div><!-- end card -->

						<div class="card card-success">
							<div class="card-header">
								<h4>Purpose</h4>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>

							<div class="card-body">
								<h5>This program is designed to enable a variety of groups such as classes, teams, clubs, departments,
									to track students' attendance/location.</h5> {{-- ' --}}
								<div class="alert alert-info col-md-6">
									<h5><i class="icon fa fa-info"></i> There are two possible modes</h5>
								</div>

								<div class="callout callout-info">
									<h5 class="text-dark">1. <u>Sign-in and sign-out</u></h5>
									<p>This tracks the time that the student signs in and also requires him/her to sign-out.</p>
									<p>Possible uses would be departments such as:</p>
									<ul>
										<li>the library
										<li>student success
										<li>detention room
										<li> etc.
									</ul>
									
									<p> This could be used for
										<ol type="i">
											<li> allowing teachers to see when a student actually arrives and leaves the library / Resource /
												Student Success / Guidance
											<li> verifying that the student has a spare when they check into the library without a slip.
											<li> tracking usage for urban-funding grants
										</ol>
										<p>These kiosks would normally be set to <b>public</b> so that all teachers can see who is there,
											when they arrived, when they left,
											and can search for a particular student.</p>
											<p>If a student forgets to signout, there is an autosignout option that will sign the student out
												at the specified time (e.g. end of period)
											</p>
								</div>

								<div class="callout callout-success">
									<h5 class="text-dark">2. <u>Present Only</u></h5>
									<p> This is used when you just need a record of who (students only) was present at a meeting and
										signing out doesn't make sense.<br>
										Examples</p>
									<ul>
										<li>Gamer's club (or any club) : used for applying to Student Council for funding, listing students
											who can get Letters.
										<li>Raider Robotics : taking attendance at the beginning of each general meeting takes an inordinate amount
											of time. This would speed it up significantly.
										<li>BILP : recording attendance in the morning (and at lunch?), formatted in a way such that entry
											to Web Attendance is simple.
										<li>Indoor sports teams : attendance for each practice. <br>
											<i>This probably won't work for outdoor teams since this program is only available via the inhouse
												school network. Wifi wouldn't reach to the field.</i></li>
									</ul>

									These kiosks would normally be set to <b>private</b> so that only the teachers running the club/team
									can see the participants and attendance.
								</div>
							
								</div><!-- end card body -->
							</div><!-- end card -->
						</div> <!-- /.tab-pane -->

						<div class="tab-pane" id="tab_2">
							<div class="card card-warning">
								<div class="card-header">
									<h4>Database administrators</h4>
								</div>
								<div class="card-body">
									<p><b>The two administrators are Michael Harwood and Larry Farquahrson.</b></p>
									<p>The administrators are the only ones who can:<br>
										<ol>
											<li>add new users and delete users
											<li>add a new kiosk, set the initial kiosk admin, and delete kiosks
										</ol>
								</div>
							</div>

							<div class="card card-warning">
								<div class="card-header">
									<h4>Kiosk administrators</h4>
								</div>
								<div class="card-body">
									<p>Each kiosk has one or more kiosk admins.<br> The kiosk admins add users to the kiosk.
										Kiosk admins can also change most of the settings of the kiosk (e.g. making the logs
										private/public).
									</p>
								</div>
							</div>

							<div class="card card-dark">
								<div class="card-header">
									<h4>Kiosk users</h4>
								</div>
								<div class="card-body">
									<p>Users can start the start the Terminals of their own kiosks.
										Only kiosk users (and kiosk admins) can view the logs of a kiosk if the kiosk is set to private.
									</p>
								</div>
							</div>

							<div class="card card-dark">
								<div class="card-header">
									<h4>General users</h4>
								</div>
								<div class="card-body">
									<p>Any user can view the settings of any kiosk and see who the users/admins of that kiosk are<br>
										Any user can view public logs and can search for students.</p>
									<p>There is a generic teacher login which acts like a user who is not assigned to any kiosks.</p>
								</div>
							</div>
						</div>
						<!-- /.tab-pane -->
						<div class="tab-pane" id="tab_3">
							<i>This tab needs to be rewritten properly</i><br>
						The terminal screen is where students actually log in or out ...
						<ul>
							<li>include screen shot</li>
							<li>Students log in by entering their computer login id, eg. smitjohn123.
								The student id number can also be used. This would be for scanning in student cards</li>
							<li>The next time that the student enters their login id they are logged out.</li>
							<li>If the user (teacher) clicks on the Beal Logo, a prompt pops up for the teacher to enter 
								the bypass password. After this is done, the teacher can then log a student in/out by typing his/her name.
							</li>
						</ul>
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab_4">
						There are a number of settings for each kiosk.<br>
						A detailed explanation of them will follow later....
						</div><!-- /.tab-pane -->
						<div class="tab-pane" id="tab_5">
						<p>Users can view the logs for each kiosk based on time (day, week, month, ...). Click on the "Logs" button in the left navigation
							panel to do this.</p>
							<p>Users can view the logs for a particular student based on time (day, week, month) or based on kiosk.<br>
								Search for the student, and then click the appropriate buttons in the display that comes up.
							</p>
							<p>Future reports will include:</p>
							<ul>
								<li>total usage of a kiosk (e.g. student success) by month and also by period.</li>
								<li>a report of attendance for "Present Only" kiosks (e.g. a club) by month.</li>
							</ul>
						</div><!-- /.tab-pane -->
					</div><!-- /.tab-content -->

				</div><!-- /.card-body -->
			</div>
			<!-- ./card -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<!-- END CUSTOM TABS -->
@endsection
