<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{--
    <link rel="stylesheet" href="{{ asset('/vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/sweetalert/sweetalert.min.css') }}"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

   

    <title>Checkin/out Terminal</title>

    <style>
        body {
            font-family: Helvetica;
            background-color: #cac5ca
        }

        input[type=text] {
            width: 15%;
            padding: 12px 20px;
            margin: 4px 0;
            box-sizing: border-box;
        }

        button[type=button],
        input[type=submit],
        input[type=reset] {
            background-color: #121117;
            border: none;
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            margin: 3px 2px;
            cursor: pointer;
            border-radius: 5px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
        }

        /* BootStrap CSS is included. Use that instead of recreating everything */

        #studentSearch {
            width: 70%;

            top: 8%;
            left: 15%;
            position: absolute;
            border: solid gray 5px;
            border-radius: 8px;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            font-size: 16px;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
        }

        #studentSearch input {
            line-height: normal;
            font-size: 20px;
        }

        #studentList {
            margin: 0 5% 5% 5%;
            color: #22264B;
            box-sizing: border-box;
        }

        .pure-form {
            display: block;
            /*  font-size: .75em; */
            padding: .2em 0 .8em;
            margin: 1.5em 0 0;
        }

        .pure-form fieldset {
            margin: 0;
            padding: .35em 0 .75em;
            border: 0
        }

        .pure-form input {
            padding: 0.5em 0.6em;
            display: inline-block;
            border: 1px solid #CCC;
            box-shadow: 0px 1px 3px #DDD inset;
            border-radius: 4px;
            vertical-align: middle;
            box-sizing: border-box;
        }

        .pure-form .pure-input-2-3 {
            width: 66%
        }

        .table-canvas {
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            border-radius: 10px;
            -pie-background: linear-gradient(#ece9d8, #E5ECD8);
            box-shadow: #666 0px 2px 3px;
            behavior: url(Include/PIE.htc);
            overflow: hidden;
            width: 100%;
        }

        .table-canvas td {
            cursor: pointer;
            cursor: hand;
        }

        /* Pure table stuff */

        .pure-table {
            border-collapse: collapse;
            border-spacing: 0;
            empty-cells: show;
            border: 1px solid #cbcbcb
        }

        .pure-table caption {
            color: #000;
            font: italic 85%/1 arial, sans-serif;
            padding: 1em 0;
            text-align: center
        }

        .pure-table td,
        .pure-table th {
            border-left: 1px solid #cbcbcb;
            border-width: 0 0 0 1px;
            font-size: inherit;
            margin: 0;
            overflow: visible;
            padding: .5em 1em;
            text-align: left;
        }

        .pure-table td .noborder {
            border: none;
        }

        .pure-table td:first-child,
        .pure-table th:first-child {
            border-left-width: 0
        }

        .pure-table thead {
            background-color: #e0e0e0;
            color: #000;
            text-align: left;
            vertical-align: bottom;
            font-weight: bold;
        }

        .pure-table td {
            background-color: white;
        }

        .pure-table tr:hover td {
            color: #DDD;
            background-color: #666;
        }

        .pure-table tr:hover td a {
            color: #DDD;
        }

        .pure-table a {
            color: #333;
        }

        .pure-table a:hover {
            text-decoration: none;
            color: #DDD;
        }


        .pure-table-odd td {
            background-color: #f2f2f2;
        }

        .pure-table-striped tr:nth-child(2n-1) td {
            background-color: #f2f2f2
        }

        .pure-table-bordered td {
            border-bottom: 1px solid #cbcbcb
        }

        .pure-table-bordered tbody>tr:last-child>td {
            border-bottom-width: 0
        }
    </style>

    {{-- script to detect if student name is being typed in, and resetTerminal upon ESC key press --}}
    <script type="text/javascript">
        function parseInput(str) {
        
        if(!isNaN(str)) return;
            
        document.getElementById("inputID").value = "";
        document.getElementById("inputID").autofocus = "false";
        document.getElementById("studentSearch").style.display = "block";      
        document.getElementById("inputName").focus();
        document.getElementById("inputName").value = str;
    }
    function resetTerminal() {
        document.getElementById("studentSearch").style.display = "none";                  
        document.getElementById("inputName").value = "";
        document.getElementById("inputID").value = "";
        document.getElementById("inputID").focus();            
    }
    </script>



    {{-- Script to load student info. JQUERY / AJAX not working --}}
    <script type="text/javascript">
    /*
        $(document).ready(function () {
            $('#button').click(function (e) {
                //if there are any hyphens, remove them.
                var inputvalue =  parseInt($("#inputID").val().replace(/-/g, ""));
                alert(inputvalue);
                $("#inputID").val('');
                $('#inputID').focus();

                jQuery.post('/terminals/1/toggleStudent/333444555');
                
                alert('X');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    async: true,
                    url: '/terminals/{{$kiosk->id}}/toggleStudent/' + inputvalue,
                    dataType: "json",
                    contentType: "application/json",
                    success: function (msg) {
                        alert('success');
                        swal(url);
                        if(msg.status === "attached"){
                            signin(msg.student);
                        }
                        else if(msg.status === "detached"){
                            signout(msg.student);
                        }
                        else{
                            errormsg();
                        }
                    },
                    error: function (err) {
                        alert('no success');
                        console.log(err);
                        errormsg();
                    }
                });
            });
        });
    */
    </script>

    {{-- Script to test if JQuery is working: it will hide the H1 that you click on --}}
    <script>
        $(document).ready(function(){
          $("h1").click(function(){
            $(this).hide();
          });
        });
    </script>

    <script type="text/javascript">
    
        $(document).ready(function () {
            $('#buttonIO').click(function (e) {
                //if there are any hyphens, remove them.
                var inputvalue =  parseInt($("#inputID").val().replace(/-/g, ""));               
                $("#inputID").val('');
                $('#inputID').focus();
                getOneStudent(inputvalue,false);
            }
            );  
        }
        );
    </script>

    {{-- Script to search for students by name --}}
    <script>
        function findStudents(str) {           
            if (str.length == 0) { 
                document.getElementById("studentList").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                   if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("studentList").innerHTML = xmlhttp.responseText;                       
                    }
                }
                xmlhttp.open("GET", "studentFind/" + str, true);
                xmlhttp.send();
            }
        }
        
        function getOneStudent(str,confirm=true) { 
            
            if (str.length == 0) { 
                document.getElementById("studentList").innerHTML = "";
                return;
            } else {         
                             
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                   if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {                       
                        // parse JSON input to display in SweetAlerts                     
                        //alert(xmlhttp.responseText);
                        $response = JSON.parse(xmlhttp.responseText);
                       if ($response.status === 'attached') {
                           if (confirm) {
                               confirmSignin($response.student);
                            } else { 
                               signin($response.student);
			    }
                       } else if($response.status === "detached"){
                            signout($response.student);
                        }
                        else{
                            errormsg();
                        }
                      //  alert($response.status);
                      // alert($response.student.firstname);
                      // document.write("123" + $response.student['studentID']);
                    }
                }
               
                xmlhttp.open("GET", "{{$kiosk->id}}/toggleStudent/" + str, true);
                xmlhttp.send();
            }
        }
    </script>

    {{-- Script to pop up sweetalerts --}}
    <script>
        function signin(student) {
            resetTerminal();                         
            swal({
                title: "Welcome " + student['firstname'] + " " + student['lastname'],
                text: "You are signed into {{$kiosk->name }} ({{$kiosk->room}})",
                icon: "success",
                timer:6000,
            }).then( function() { $('#input').focus() }
	        );
        } //end
        function signout(student) {
            resetTerminal();                         
            swal({
                title: "Goodbye " + student['firstname'] + " " + student['lastname'],
                text: "You are signed out of {{$kiosk->name }} ({{$kiosk->room}})",
                icon: "success",              
                animation:"false",
 		        timer:6000,            
		    }).then( function() { $('#inputID').focus() }
		    );
        }
        function errormsg() {
            swal({
                title: "ERROR!",
                icon: "error",
                text: "The student was not found or there was an unexpected database error.",               
 		        timer:6000,
            }).then(  function() { $('#inputID').focus() }
        	);
        } 
	//TODO: this still signs the student in if the screen is clicked outside the SWAL. Fix by printing the value and seeing what it is.
	//How is the student being signed in when nothing is popping up on the screen?
	//The CONFIRM SWeetAlert is only popping up AFTER the toggle has been done!!!
        function confirmSignin(student) {
            swal({
                title: "Confirm Sign-in",
                text: "Please confirm that this is the correct student being signed in",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((proceed) => {
			if (proceed) {
				console.log("signing in");
				signin(student);
			} 
                });
        }
    </script>
</head>

<body>
    <div class="text-center">

        <!-- html to display student listing -->
        <div id="studentSearch" class="shadow-lg">
            <form class="pure-form">
                <span class="text-light hide">Enter First Name, Last Name, or Student Number...</span>
                <fieldset>
                    <input class="pure-input-2-3" autofocus="" id="inputName" type="text" onkeyup="findStudents(this.value)" onkeydown="if (event.keyCode === 27) resetTerminal();"
                        placeholder="Enter First Name, Last Name, or Student Number...">
                </fieldset>
            </form>
            <!-- the student table is created here at "studentList". There is also formatting for this in the css  -->
            <div id="studentList" class="text-center"></div>


        </div>

        {{-- <button id="button1" onclick="signout(333444555)">Test of swal()</button><br> --}}
      
        <img style="margin-top: 10vh; margin-bottom:3vh;" src="{{asset('img/14.png')}}" alt="HB Beal" height="400vh"><br>

        <h1 class="text-center">{{$kiosk->name}}</h1>

        <input type="text" style="text-align: center" id="inputID" 
            onkeyup="parseInput(this.value)" 
            onkeydown="if (event.keyCode === 13) document.getElementById('buttonIO').click()"
            autofocus><br><br>
        <button type="button" id="buttonIO">Sign in/out</button>

        
        <!-- This uses toggleStudent_v2 . It would work fine, but was never finished as I needed to get the XMLHttp working.
        <form role="form" action="/terminals/{{ $kiosk->id }}/toggleStudent" method="post">
            <input type="text" style="text-align: center" id="studentID" name="studentID" autofocus><br> {{ csrf_field()
            }} {{-- add onclick to prevent empty input field --}}
            <button type="submit" onclick="">submit - to TerminalController</button>
        </form>
        -->

    </div>
    <br>
    <br>
    <br>

</body>

</html>
