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
						@include('child.helpTab1')
					</div> <!-- /.tab-pane -->

					<div class="tab-pane" id="tab_2">
						@include('child.helpTab2')
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
