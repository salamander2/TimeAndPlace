
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
           <td> {{$student->lastname }}, {{$student->firstname}}</td>
           <td>{{$student->studentID}}</td>
        </tr>
        
            
        @endforeach

        </tbody>
        </table>
        
