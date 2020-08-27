<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/terminal.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" ></script>

    <title>Checkin/out Terminal</title>

    <style>
    .swalImg img{
        border: solid 6px #333;
        border-radius:8px;
        width:170px;
        height:200px
    }
    </style>

    {{-- script to detect if student name is being typed in, and resetTerminal upon ESC key press --}}
    <script type="text/javascript">
        var overlayOn = false;

        function resetFocus(){
            if (overlayOn) {
                    $('#inputName').focus();
            } else {
                    $('#inputID').focus();
            }
        }

        function parseInput(str) {
        
            if(!isNaN(str)) return; //ignore this if it is a student number being typed in
                
            document.getElementById("inputID").value = "";
            document.getElementById("inputID").autofocus = "false";
            document.getElementById("studentSearch").style.display = "block";      
            document.getElementById("inputName").focus();
            document.getElementById("inputName").value = str;
        }

        function getPassword() {
            Swal.fire({
                title: "Enter teacher password",
                text: "in order to login students by name or exit the Terminal",
                icon: "warning",  
		input: 'password',
		inputAttributes: {
		    maxlength: 20,
		    autocapitalize: 'off',
		    autocorrect: 'off',
		    },
                }).then((password) => {

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        async: true,
                        url: '/verifyTeacher',
                        data: {                            
							//SweetAlert2 requires the .value
                            pwdin : password.value    //a data field cannot be named password!
                        },
                        dataType: "json",
                        // contentType: "application/json",     //this totally messes up data transfer
                        success: function (msg) {
                            if(msg.status === "success"){
                                showOverlay();
                            }                            
                            else{
                                SWerrormsg("Invalid teacher password typed");
                            }
                        },
                        error: function (err) {
                            alert('The ajax query did not run ' + err);
                            console.log(err);
                            //errormsg();
                        }
                    });
                }
            );

        }

        function showOverlay() {            
            document.getElementById("exitBtn").classList.remove('hide');
            document.getElementById("inputID").value = "";
            document.getElementById("inputID").autofocus = "false";
            document.getElementById("studentSearch").style.display = "block";
            document.getElementById("inputName").focus();
	    overlayOn = true;
        }

        function resetTerminal() {
            document.getElementById("exitBtn").classList.add('hide');
            document.getElementById("studentSearch").style.display = "none";
            document.getElementById("studentList").innerHTML = "";
            document.getElementById("exitBtn").style.display = "hide";
            document.getElementById("inputName").value = "";
            document.getElementById("inputID").value = "";
            document.getElementById("inputID").focus();            
	    overlayOn = false;
        }
    </script>


    {{-- Script to test if JQuery is working: it will hide the H1 that you click on --}}
    <script>
        $(document).ready(function(){
          $("h1").click(function(){
            $(this).hide();
          });
        });
    </script>

    {{-- Script that calls "toggleOneStudent" when you click on the sign in/out button--}}
    <script>    
        $(document).ready(function () {
            $('#buttonIO').click(function (e) {
                loginID = $("#inputID").val()
                $("#inputID").val('');
                $('#inputID').focus();
                @if ($kiosk->requireConf) 
                    confirmStudent(loginID);
                @else                
                    toggleOneStudent(loginID);
                @endif
                
            }
            );  
        }
        );
   
        /* This function gets all of the students that match the string being typed: 
            ie. their first name, last name, or student number 
            The data is returned as a table in a child view. 
            Clicking on a student or their ID takes you to "toggleOneStudent()" */
        function findStudents(str) {  
            if (str.length == 0) { 
                document.getElementById("studentList").innerHTML = "";
                //TODO: should this just call "resetTerminal()" ?
                return;
            } 
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    //document.write(xmlhttp.responseText);
                    document.getElementById("studentList").innerHTML = xmlhttp.responseText; 
                    document.getElementById("inputName").focus();                     
                }
            }
            xmlhttp.open("GET", "studentFind/" + str, true);
            xmlhttp.send();
        }       
    
        
        function confirmStudent(str) {
            if (str.length == 0) return;

            //no data for GET since it's in the URL
            var ajaxReq = $.ajax('/studentsJSON/'+str, {
                dataType: 'json',
                timeout: 500,
                success: function (data, status, jqXhr) {
                    //alert('d1 ' + data.photoURL);
                    //alert('d2 ' + data.age);                    
                    //alert('status ' + status);
                    //alert('student' + data.record['firstname'])
                    
                   // alert('dada X ' + $response);
                    //$('p').append(data.firstName + ' ' + data.middleName + ' ' + data.lastName);
                    SWconfirmSignin(data.record, data.photoURL);
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    alert('Error: ' + errorMessage);
                }
            });
        }            

        /* This function gets a student based on their student ID (stored in 'str)
            It runs "toggleStudentID" which then logs them in or out.
            TODO: rewrite as a POST method
        */
        function toggleOneStudent(str) { 
            
            if (str.length == 0) return;
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {                       
                    // parse JSON input to display in SweetAlerts                     
//                    alert(xmlhttp.responseText);  //DEBUG

                    $response = JSON.parse(xmlhttp.responseText);
                    if ($response.status === 'signed in') {
                        SWsignin($response.student, $response.photoURL);
                    } else if($response.status === "signed out"){
                        SWsignout($response.student);
                    } else if($response.status === "present"){
                        SWpresent($response.student, $response.photoURL);
                    } else if($response.status === "already present"){
                        SWalreadyPresent($response.student);
                    } else if($response.status === "not found"){
                        SWerrorID();
                    } else{
                        SWerrormsg();
                    }
                    //  alert($response.status);
                    // alert($response.student.firstname);
                    // document.write("123" + $response.student['studentID']);
                    $('#inputID').focus()
                }
            }
            
            xmlhttp.open("GET", "{{$kiosk->id}}/toggleStudentID/" + str, true);
            xmlhttp.send();
        
        }
    </script>

    {{-- Script to pop up sweetalerts --}}
    <script>
        function SWsignin(student, photoURL) {
            //resetTerminal();                         
            Swal.fire({
                title: "Welcome " + student['firstname'] + " " + student['lastname'],
                text: "You are signed into {!!$kiosk->name !!} ({!!$kiosk->room!!})",
                @if ($kiosk-> showPhoto)
                    className: "swalImg",
					imageUrl: photoURL,
					// imageWidth: 400,
					// imageHeight: 200,
					// imageAlt: 'Student Photo',
                @else
                    icon: "success",
                @endif
                
                @if ($kiosk->swalOKbtn)
                    //ok button displayed
                @else
					showConfirmButton: false,
                @endif
                timer:3000,
            }).then( function() { $('#inputID').focus() }
	    );
        } //end

        function SWsignout(student) {
            //resetTerminal();                         
            Swal.fire({
                title: "Goodbye " + student['firstname'] + " " + student['lastname'],
                text: "You are signed out of {!!$kiosk->name !!} ({!!$kiosk->room!!})",
                icon: "success",
                @if ($kiosk->swalOKbtn)
                    //ok button displayed
                @else
					showConfirmButton: false,
                @endif                
                timer:3000,            
            }).then( function() { $('#inputID').focus() }
	    );
        }

        function SWpresent(student, photoURL) {
            //resetTerminal();                         
            Swal.fire({
                title: "Welcome " + student['firstname'] + " " + student['lastname'],
                text: "You have been marked present for {!!$kiosk->name!!} ({!!$kiosk->room!!}) today",
                @if ($kiosk-> showPhoto)
                    className: "swalImg",
		    imageUrl: photoURL,
		    // imageWidth: 400,
		    // imageHeight: 200,
		    // imageAlt: 'Student Photo',
                @else
                    icon: "success",
                @endif
                @if ($kiosk->swalOKbtn)
                    //ok button displayed
                @else
					showConfirmButton: false,
                @endif
                timer:3000,            
	        }).then( function() { $('#inputID').focus() }
	        );
        }

        function SWalreadyPresent(student) {
            //resetTerminal();                         
            Swal.fire({
                title: "Hey " + student['firstname'] + " " + student['lastname'],
                text: "You have already been marked present for {!!$kiosk->name!!} ({!!$kiosk->room!!}) today!",
                icon: "warning",                
                @if ($kiosk->swalOKbtn)
                    //ok button displayed
                @else
					showConfirmButton: false,
                @endif
                timer:3000,            
	        }).then( function() { $('#inputID').focus() }
	        );
        }

        function SWerrorID() {
            Swal.fire({
                title: "ERROR: Invalid login id!",
                icon: "error",                
                text: "The student was not found or there was an unexpected database error.", 
				timer:4000,
                }).then(  function() { $('#inputID').focus() }
      	    );
        }

        function SWerrormsg(str) {
            if (str.length == 0) str = "The student was not found or there was an unexpected database error!"
            Swal.fire({
                title: "ERROR!",
                icon: "error",
                text: str,               
				timer:4000,
            }).then(  function() { $('#inputID').focus() }
        	);
        }
	
        function SWconfirmSignin(student, photoURL) {            
            //<img class="student-img" src="{-- $photoURL --}" width="170" height="200">
            Swal.fire({
                title: "Confirm Sign-in for "+ student['firstname'] + " " + student['lastname'],
                text: "Please confirm that this is the correct student being signed in" ,
                //html: "<img src='"+photoURL+"' style='width:170px;height:200px'>",
                //icon: "{{asset('img/14.png')}}",
                @if ($kiosk-> showPhoto)
                    className: "swalImg",
					imageUrl: photoURL,
					// imageWidth: 400,
					// imageHeight: 200,
					// imageAlt: 'Student Photo',
                @else
                    icon: "warning",
                @endif
                //buttons: true, //show a cancel button also
                //dangerMode: true, //set focus on cancel
				showCancelButton: true,
				focusCancel: true,
                })
                .then((proceed) => {
                if (proceed) {
                    //console.log("signing in");
                    //SWsignin(student);
                    toggleOneStudent(student['studentID']);
                } 
            });
        }
    </script>
</head>

<body>

        <div class="ml-3 my-3 hide" id="exitBtn">
            {{-- TODO: this should work as soon as the user is no longer logged in --}}
            <a href="{{ route('login') }}"><button type="button" class="btn btn-info border-dark">Exit Terminal</button></a>
        </div>

		{{-- this resets the focus if the screen is clicked anywhere else (except at the very bottom) --}}
        <div id="maincontent" class="text-center" onclick="resetFocus()">
        {{-- <div id="maincontent" class="text-center"> --}}

        <!-- html to display student listing -->        
        <div id="studentSearch" class="shadow-lg">
            
            <form class="pure-form">
                <h3 class="text-light">Sign student in/out using first or last name</h3>
                <h5  class="text-light">Press 'ESC' key to exit</h5>
                <fieldset>
                    <input class="pure-input-2-3" autofocus="" id="inputName" type="text" onkeyup="findStudents(this.value)" onkeydown="if (event.keyCode === 27) resetTerminal();"
                        placeholder="Enter First Name, Last Name, or Student Number...">
                </fieldset>
            </form>
            <!-- the student table is created here at "studentList". There is also formatting for this in the css  -->
            <div id="studentList" class="text-center"></div>
        </div>

        <img style="margin-top: 10vh; margin-bottom:3vh;" src="{{asset('img/terminalLogo.png')}}" 
        onclick="getPassword()" alt="HB Beal" height="400vh"><br>

        <h1 class="text-center">{{$kiosk->name}}</h1>
        <div class="term">
            <input type="text" style="text-align: left" id="inputID" size=20
                placeholder="" 
                onkeydown="if (event.keyCode === 13) document.getElementById('buttonIO').click()"
                autofocus>
            <p style="color:#333">Enter your computer login id or your student number</p>        
            <button type="button" id="buttonIO">Sign In/Out</button>
        </div>
    </div>
    <br>
    <br>
    <br>
    <script type="text/javascript">
        //always maintain focus
        document.getElementById("inputID").focus();
        document.getElementById("inputID").autofocus = "true";
    </script>

</body>

</html>
