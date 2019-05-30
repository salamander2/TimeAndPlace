
{{--  view to display all attendance for one particular event: Status is P(resent), L(ate), A(bsent), or -(absent)  --}}
<!doctype HTML>
<html>
<head>
<title>Attendance for {{ $event->name }}</title>
<style>
xxxtable {
  font-size: 100%;
  font-family: monospace;
}
</style>
</head>
<body>

<h2>
    Attendance for {{ $event->name }}
</h2>                
    
        <table cellspacing='0' cellpadding='3'>
            <tr align="left"><th style="width:17em">Student Name</th><th>Status</th><th>Time Signed in</th></tr>
        @foreach ($array as $arr) 
	    <tr >
            <td >{{$arr[0]}}</td>

            @if($arr[1] == 'A' || $arr[1] == '-') 
            <td> Absent </td>
            @elseif ($arr[1] == 'L')
            <td> Late </td>
            @elseif ($arr[1] == 'P')
            <td> </td>
            @else
            <td> </td>
            @endif
                        
            <td>{{$arr[2]}}</td>
            
        </tr>
        @endforeach
        </Table>
        <h6><br> {{ count($array)}} students </h6>

</body>
</html>
