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
					</div>

					<div class="tab-pane" id="tab_2">
						@include('child.helpTab2')
					</div>

					<div class="tab-pane" id="tab_3">
						@include('child.helpTab3')
					</div>

					<div class="tab-pane" id="tab_4">
						@include('child.helpTab4')
					</div>

					<div class="tab-pane" id="tab_5">
						@include('child.helpTab5')
					</div>

					<div class="tab-pane" id="tab_6">
						@include('child.helpTab6')
					</div>
				</div><!-- /.tab-content -->

			</div><!-- /.card-body -->
		</div>
		<!-- ./card -->
	</div>
	<!-- /.col -->
</div>
<!-- /.row -->
@endsection
