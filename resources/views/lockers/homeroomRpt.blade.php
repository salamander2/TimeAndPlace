<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h1>Locker Listing by Course</h1>


<h2>{{ $coursecode }}</h2>

<table>
<tr>
<th>Student</th>
<th>Locker#</th>
<th>Combination #</th>

</tr>

@foreach($array as $row)
{{-- $row[0] = studentID, $row[1] = lname,fname, $row[2] = locker_id, $row[3] = combination;   --}}
{{-- start one row of data --}}
	<tr
@if ($loop->iteration %2 == 0)
	style="background-color:#EEE;">
	@else
	>
	@endif
	<td>{{$loop->iteration }}.&nbsp;&nbsp;{{$row[0]}} : {{$row[1]}} </td>
	@if($row[2] == "")
	<td>
	<input type="text" maxlength="5" size=5 class="" id="lockerNum{{$row[0]}}" name="lockerNum"> 
	</td>
	<td> <input type="text" class="" id="combination{{$row[0]}}" name="combination"> </td>
	@else
	<td>
	<input style="color:black;" disabled type="text" maxlength="5" size=5 class="" id="lockerNum{{$row[0]}}" name="lockerNum" value="{{$row[2]}}"> 
	</td>
	<td>
	<input disabled type="text" class="" id="combination{{$row[0]}}" name="combination" value="{{$row[3]}}"> </td>
	@endif
	</tr>
	@endforeach

	</table>

	</body>
	</html>
