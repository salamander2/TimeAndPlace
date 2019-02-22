

   
        $schoolDB = connectToDB("schoolDB", $sql_user, $sql_pass);
                
        #$query = "SELECT students.studentID, students.firstname, students.lastname FROM students WHERE firstname LIKE '$q%' or lastname LIKE '$q%' or studentID LIKE '$q%' ORDER BY lastname, firstname";
            $q = $q.'%';
            $q2 = $q;
            $q3 = $q;
            $query = "SELECT students.studentID, students.firstname, students.lastname FROM students WHERE firstname LIKE ? or lastname LIKE ? or studentID LIKE ? ORDER BY lastname, firstname";

            <table class="pure-table pure-table-bordered table-canvas" style="border:none;">
        <thead>
        <tr>
        <th>Student Name</th>
        <th>Student Number</th>        
        </tr>
        </thead>
        <tbody>
        
        <?php
        // printing table rows: student name, student number, selected (if isTeamAdmin)
        while ($row = mysqli_fetch_assoc($resultArray)){ 
        
            $selected = false;
            if ($row['selected'] == 1) $selected=true;
        
            //1. Is the student "at risk" - ie. does he/she have an sssInfo record?
            //this always gives 1 row with either a 1 or 0 in it.
            #$sql = "SELECT EXISTS(SELECT 1 FROM sssInfo WHERE studentID='" . $row['studentID'] . "')";
            #$sql = "SELECT studentID FROM sssInfo WHERE studentID='" . $row['studentID'] . "'";
        
            $sql = "SELECT studentID FROM sssInfo WHERE studentID = ? ";
            if ($stmt = $sssDB->prepare($sql)) {
                $stmt->bind_param("i", $row['studentID']);
                $stmt->execute();
                $stmt->bind_result($result2);
                //$stmt->fetch(); //NONONO - not if you're storing the result
                $stmt->store_result();
                $num_rows = $stmt->num_rows;
                $stmt->close();
            } else {
                $message_  = 'Invalid query: ' . mysqli_error($sssDB) . "\n<br>";
                $message_ .= 'SQL: ' . $sql;
                die($message_); 
            }
        
            if ($num_rows == 0) $status = 0; 
            else $status = 1;
        
            if ($selected) $status = $status * 10;	//to apply highlight to the row
        
        #  <!-- select page based on "$nextPage"  -->
        # should look like this: <tr onclick="window.document.location='commentPage.php?ID=339671216';" class="row0">
        # old code: echo "<tr onclick=".'"'."window.document.location='commentPage.php?ID=".$row['studentID'] ."';".'" class="row0">';
        #echo "<tr onclick=\"window.document.location='commentPage.php?ID=". $row['studentID'] . "';\" class=\"row$num_rows\">";
            if ($activate) {
                echo "<tr class=\"row$status\">";
            } else {
                echo "<tr>";
            }
            echo "<td onclick=\"window.document.location='$nextPage?ID=". $row['studentID'] . "';\" >".$row['lastname'], ", ", $row['firstname'] ."</td>";
            echo "<td onclick=\"window.document.location='$nextPage?ID=". $row['studentID'] . "';\" >".$row['studentID']. "</td>";
           
            echo "</tr>";
        
        } //this is the end of the while loop
        ?>
        
        </tbody>
        </table>
        
