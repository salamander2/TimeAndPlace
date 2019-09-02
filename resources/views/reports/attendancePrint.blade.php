{{--  view to display all attendance for a meeting -- all months --}}
<!doctype HTML>
<html>
<head>
<title>Attendance for {{ $kiosk->name }}</title>
<style>
table {
  /* font-size: 100%;
  font-family: monospace; */
  border-collapse: collapse;
}
table, th, td {
  border: 1px solid #AAF;
}
</style>
</head>
<body>

            
    <h2>
    @if ($code == 'A')
        All attendance for {{ $kiosk->name }}
    @else
        Monthly attendance for {{ $kiosk->name }}
    @endif
    </h2>                


    <table cellspacing='0' cellpadding='3' border="1">
    @foreach ($array as $arr) 
        <tr>
        
        @foreach ($arr as $index=>$value) 
            {{-- @if ($loop->first || $loop->parent->first) --}}
            @if ($loop->parent->first)
                <td><b>&nbsp;{{ $value }}&nbsp;</b></td>
            @else
                @if($loop->first)
                <td>{{ $value }} &nbsp; &nbsp;</td>
                @else
                <td align="center">{{ $value }}</td>
                @endif
            @endif
        @endforeach
        </tr>
    @endforeach
    </Table>
    <h5><br> {{ count($array) -1 }} students </h5>

</body>
</html>
