@extends('layouts.app')

 @section('content-header')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Help &amp; Information</h1>
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


<div class="container-fluid">
<div class="row">
    <div class="col-lg-9">
	<div class="card card-success">
	<div class="card-header">
 	    <div class="card-title"><h3>Purpose</h3></div>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>

	<div class="card-body">
	<h4>This program is designed to enable a variety of groups such as classes, teams, clubs, departments, to track students' attendance/location.</h4>
	<div class="alert alert-info col-md-6">
	  <h5><i class="icon fa fa-info"></i> There are two possible modes</h5>
	</div>

	<div class="callout callout-info">
		<h5 class="text-primary">1. <u>Sign-in and sign-out</u></h5>

		<p>Possible uses would be departments such as:</p>
		<ul>
		<li>the library
		<li>student success
		<li>detention room
		<li> etc.
		</ul>
		<p> where the students sign in and out.</p>
		<p> This could be used for
		<ol type="i">
		<li> allowing teachers to see when a student actually arrives and leaves the library / Resource / Student Success / Guidance
		<li> verifying that the student has a spare when they check into the library without a slip.
		<li> tracking usage for urban-funding grants
		</ol>
		<p>These kiosks would normally be set to <b>public</b> so that all teachers can see who is there, when they arrived, when they left, 
		and can search for a particular student.</p>
	</div>

	<div class="callout callout-info">
		<h5 class="text-primary">2. <u>Present Only</u></h5>
		<p> This is used when you just need a record of who (students only) was present at a meeting and signing out doesn't make sense.<br>
		Examples</p>
		<ul>
		<li>Gamer's club (or any club) : used for applying to Student Council for funding, listing students who can get Letters.
		<li>Raider Robotics : signing in at the beginning of each general meeting takes an inordinate amount of time. This would speed it up significantly.
		<li>BILP : recording attendance in the morning (and at lunch?), formatted in a way such that entry to Web Attendance is simple.
		<li>Indoor sports teams : attendance for each practice. <br>
		<i>This probably won't work for outdoor teams since this program is only available via the inhouse school network. Wifi wouldn't reach to the field.</i></li>
		</ul>

		These kiosks would normally be set to <b>private</b> so that only the teachers running the club/team can see the participants and attendance.
	</div>
	<h5><i class="icon fa fa-star"></i> The Home screen shows the students who are currently signed in to all the public kiosks</h5>
	</div>
	</div>
	<div class="card card-success">
	<div class="card-header">
 	    <div class="card-title"><h3>Terminology</h3></div>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
	<div class="card-body">
	<p>
	<b><u>Kiosk:</u></b> the team, club, group, department, ... that is tracking attendance.
	Because this is program flexible enough to encompass all of these different groups/teams/classes/categories, "kiosk" is being used as the general term for them all.
	</p><p>
	<b><u>Terminal:</u></b> the screen that is used for students to log in and log out.  </p>
	</div></div>

	<div class="card card-primary">
	<div class="card-header">
 	    <div class="card-title"><h3>Roles:</h3></div>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
	<div class="card-body">
		<div class="card card-warning">
		    <div class="card-header"><h4>Database administrators</h4></div>
		    <div class="card-body">
			<p><b>The two administrators are Michael Harwood and Larry Farquahrson.</b></p>
			<p>The administrators are the only ones who can:<br>
			<ol><li>add users and delete users
			<li>add a new kiosk, set the initial kiosk admin, and delete kiosks
			</ol>
		    </div>
		</div>

		<div class="card card-warning">
		    <div class="card-header"><h4>Kiosk administrators</h4></div>
		    <div class="card-body">
			<p>Each kiosk has one or more kiosk admins.<br> The kiosk admins add users to the kiosk. 
			Kiosk admins can also change most of the settings of the kiosk (e.g. making the logs private/public).</p>
		    </div>
		</div>

		<div class="card card-dark">
		    <div class="card-header"><h4>Kiosk users</h4></div>
		    <div class="card-body">
			<p>Users can start the start the Terminals of their own kiosks. 
			Only kiosk users (and kiosk admins) can view the logs of a kiosk if the kiosk is set to private.
			</p>
		    </div>
		</div>

		<div class="card card-dark">
		    <div class="card-header"><h4>General users</h4></div>
		    <div class="card-body">
			<p>Any user can view the settings of any kiosk and see who the users/admins of that kiosk are<br>
			Any user can view public logs.</p>
			<p>There is a generic teacher login which acts like a user who is not assigned to any kiosks.</p>
		    </div>
		</div>
	</div></div>
    </div>   
</div>
</div>


@endsection






