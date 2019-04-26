{{--  This HTML is included in terminal.blade.php , used for finding students and then sign in/out  --}}
<table class="pure-table pure-table-bordered table-canvas" style="border:none;">
   <thead>
      <tr>
         <th>Student Name</th>
         <th>Student Number</th>
      </tr>
   </thead>
   <tbody>

      @foreach ($students as $student)
      <tr>
		{{-- don't put <a href=""> around the TD</a> - it ends up going elsewhere rather than to the JS --}}
         <td onclick="toggleOneStudent({{$student->studentID}})">{{$student->lastname }}, {{$student->firstname}}</td>
         <td onclick="toggleOneStudent({{$student->studentID}})">{{$student->studentID}}</td>
      </tr>
      @endforeach

   </tbody>
</table>
