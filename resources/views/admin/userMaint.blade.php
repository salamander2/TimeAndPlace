@extends('layouts.app')

@section('content')
<div class="container">
    <h2>USER MAINT (list users)</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
<table>
		@foreach($users as $user) 
			</li>
<tr>
	<td style="color:black;" >{{ $user->username }}</td>
	<td style="color:black;" >{{ $user->fullname }}</td>
	<td style="color:black;"><input id="isTeam_row1" type="checkbox" value="isTeam"></td>
	<td><button type="submit" onclick="updateRow(1,'akirkham')">Update</button></td>
	<td><a href="deleteUser.php?ID=akirkham"><button type="submit" name="delete" style="color:red;" onclick="return confirm('Are you sure?');" >Delete</button></a></td>
	<td><a href="resetPWD.php?ID=akirkham"><button type="submit" name="changePWD" onclick="return confirm('Are you sure?');" >Reset Password</button></a></td>
	<td style="color:black;">{{ $user->defaultPWD }}</td></tr>

		@endforeach
</table>
                </div>
            </div>
        </div>
    </div>
        <div class="links">
	<ul>
	    <li><a href="https://laravel.com/docs">Admin Options</a></li>
            <li><a href="https://laravel.com/docs">Change password</a></li>
	</ul>
        </div>
</div>
@endsection
