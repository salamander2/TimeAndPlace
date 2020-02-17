@extends('layouts.app')

{{-- 
This page is the main page that deals with cleaning up the data base, particularly deleting students who are no longer at the school.
 --}}

@section('content-header')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Delete Old Students</h1>
			</div>

			{{--  <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>  -->
            <li class="breadcrumb-item active"><i class="fas fa-home"></i>Home</li>
          </ol>
        </div>   --}}

		</div>
	</div>
</div>
@endsection

@section('content')
<div class="card">
<div class="card-body">
	<p>This will search through the database and delete all students that are not in the current Markbook file</p>
	<p>Only do this in September</p>
	<div class="row">

		<div class="offset-1 col-4">
			<form method="POST" action="XdelGrads" enctype="multipart/form-data"> @csrf
				<div class="info-box border border-danger text-dark">
					<div class="info-box-content">
						<h3 class="info-box-text">Delete all<br>old students</h3>
						<div class="border border-primary float-left">
						<input type="file" name="fileupload" value="fileupload" id="fileupload"  accept="text/plain">
						</div>
						<label for="fileupload">First select Markbook file to upload</label>
					</div><!-- /.info-box-content -->
				</div><!-- /.info-box -->
		</div>
		
		<div class="col-2 info-box border border-danger">
			<div class="info-box-content">
				<p>Run the deletion program</p>
				<button type="submit" class="btn btn-primary"><h4><i class="fas fa-indent"></i> Go</h4></button>
			</div>
		</div>
		</form>

		<div class="col-3 info-box ">
			<div class="info-box-content">
				<h4><i class="text-success fas fa-edit"></i>NOTE</h4>
				<p>Format of Markbook data:</p>
				<ul>
				<li>Header row</li>
				<li>313340589,Smith,John,F,dob .... </li>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>

<div class="row">
	<div class="col-12">
		<!-- Custom Tabs -->
		<div class="card Xcard-primary ">
			<div class="card-header d-flex p-0 bg-dark">
				<ul class="nav nav-pills pt-2 pl-2 pr-2">
					<li class="nav-item"><a class="mx-1 nav-link active" href="#tab_1" data-toggle="tab">Overview</a></li>
					<li class="nav-item"><a class="mx-1 nav-link" href="#tab_2" data-toggle="tab">User Roles</a></li>
					<li class="nav-item"><a class="mx-1 nav-link" href="#tab_3" data-toggle="tab">Terminal Screen</a></li>
					<li class="nav-item"><a class="mx-1 nav-link" href="#tab_4" data-toggle="tab">Kiosk Settings</a></li>
				</ul>
			</div><!-- /.card-header -->
			<div class="card-body">
				<div class="tab-content">
					{{--TAB 1 --}}
					<div class="tab-pane active" id="tab_1">

						<div class="card card-warning">
							<div class="card-header">
								<h4>Tab 1</h4>
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
								</div>
							</div>
							<div class="card-body">
								<h5><b><u>Kiosk:</u></b> the team, club, group, department, ... that is tracking attendance.
									Because this is program flexible enough to encompass all of these different
									groups/teams/classes/categories, "kiosk" is being used as the general term for them all.
								</h5>
							</div>
						</div><!-- end card -->

					</div> <!-- /.tab-pane -->

					{{--TAB 2 --}}
						<div class="tab-pane" id="tab_2">
							<div class="card card-warning">
								<div class="card-header">
									<h4>Tab 2</h4>
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
						</div>
						<!-- /.tab-pane -->

						<div class="tab-pane" id="tab_3">
							<h3>Tab 3</h3>
						</div><!-- /.tab-pane -->

						<div class="tab-pane" id="tab_4">
						<h3>Tab 4</h3>
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