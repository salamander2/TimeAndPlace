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
			<form method="POST" action="delGrads" enctype="multipart/form-data"> @csrf
				<div class="info-box border border-danger text-dark">
					<div class="info-box-content">
						<h3 class="info-box-text">Delete all<br>old students</h3>
						<div class="border border-primary float-left">
						<input type="file" name="fileupload" value="fileupload" id="fileupload"  accept="text/plain">
						</div>
						<label for="fileupload">First select Markbook file to upload<br>e.g. update_g3.txt</label>
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
					<li class="nav-item"><a class="mx-1 nav-link active" href="#tab_1" data-toggle="tab">Students NOT deleted</a></li>
					<li class="nav-item"><a class="mx-1 nav-link" href="#tab_2" data-toggle="tab">Students over 21 deleted</a></li>
					<li class="nav-item"><a class="mx-1 nav-link" href="#tab_3" data-toggle="tab">Students deleted (not in Markbook)</a></li>
				</ul>
			</div><!-- /.card-header -->
			<div class="card-body">
				<div class="tab-content">
					{{--TAB 1 --}}
					<div class="tab-pane active" id="tab_1">
						@isset($studentsNoDelete)
						<div class="card card-warning">
							<div class="card-header">
								<h4>List of students NOT being deleted</h4>
							</div>
							<div class="card-body">
							<p>This is a list of the students who are NOT in the Markbook file, but who cannot be deleted because:</p>
							<ul>
							<li>they have a LOG file from this school year (they have checked into the library... since Sept)</li>
							<li>or they have a WAITLIST entry</li>
							<li>or they have comments in the AT-RISK database</li>
							<li>and they are not 21</li>
							</ul>
							</div>
							<table>
							@foreach ($studentsNoDelete as $rec)
							<tr><td>
								{{$rec->studentID}}, {{$rec->firstname}} {{$rec->lastname}}
							</td></tr>
							@endforeach
							</table>
						</div><!-- end card -->
						@endisset
					</div> <!-- /.tab-pane -->

					{{--TAB 2 --}}
						<div class="tab-pane" id="tab_2">
						TAB2
						@isset($students21Delete)
							<div class="card card-warning">
								<div class="card-header">
									<h4>These students are automatically being deleted because they are aged 21 or older</h4>
								</div>
								<div class="card-body">
									<p>Any log file, waitlist, and comment file is being deleted too</p>
								</div>
								<table>
								@foreach ($students21Delete as $rec)
								<tr><td>
									{{$rec->studentID}}, {{$rec->firstname}} {{$rec->lastname}}
								</td></tr>
								@endforeach
								</table>
							</div>
						@endisset
						</div><!-- /.tab-pane -->

					{{--TAB 3 --}}
						<div class="tab-pane" id="tab_3">
						TAB3
						@isset($studentsYesDelete)
							<div class="card card-warning">
								<div class="card-header">
									<h4>These students have been deleted ...</h4>
								</div>
								<div class="card-body">
									<p>They are NOT in markbook and don't have any indication that they are still in the school (via database entries)</p>
								</div>
								<table>
								@foreach ($studentsYesDelete as $rec)
								<tr><td>
									{{$rec->studentID}}, {{$rec->firstname}} {{$rec->lastname}}
								</td></tr>
								@endforeach
								</table>
							</div>
						@endisset
						</div><!-- /.tab-pane -->


					</div><!-- /.tab-content -->

				</div><!-- /.card-body -->
				{{-- @if(null==$studentsYesDelete || null==$studentsYes21Delete || null==$studentsNoDelete) --}}
				<div class="info-box bg-info">Student ids will be listed here once the deletion has occured</div>
				{{-- @endif --}}
			</div>
			<!-- ./card -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->
	<!-- END CUSTOM TABS -->
@endsection