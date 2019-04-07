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
    <link href="{{ asset('css/terminal.css') }}" rel="stylesheet">

    <title>Checkin/out Terminal</title>




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
                        //document.write(xmlhttp.responseText);
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
            placeholder="Type in your computer login id" size=20            
            onkeydown="if (event.keyCode === 13) document.getElementById('buttonIO').click()"
            autofocus>
        <br><br>
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
    <script type="text/javascript">
        document.getElementById("inputID").focus();
        document.getElementById("inputID").autofocus = "true";
    </script>
</body>

</html>
