{{--  This HTML is included in topNavbar.blade.php , used for finding students and then displaying log  --}}
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
         <td><a href="/logs/byStudent/{{$student->studentID}}">{{$student->lastname }}, {{$student->firstname}}</a></td>         
         <td><a href="/logs/byStudent/{{$student->studentID}}">{{$student->studentID}}</a></td>
      </tr>
      @endforeach

   </tbody>
</table>
