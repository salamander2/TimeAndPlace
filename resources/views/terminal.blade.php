<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{--
    <link rel="stylesheet" href="{{ asset('/vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/sweetalert/sweetalert.min.css') }}"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{asset('/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>

    <!-- None of this works
    <script src="{{ asset('/vendor/js/jquery.js') }}"></script>
    <script src="{{ asset('/vendor/js/mask.js') }}"></script>
    <script src="{{ asset('/vendor/js/bootstrap.min.js') }}"></script>
-->

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
        }

        /* BootStrap CSS is included. Use that instead of recreating everything */

        #studentSearch {
            width: 70%;
            height: 85%;
            top: 8%;
            left: 15%;
            position: absolute;
            border: solid gray 5px;
            border-radius: 8px;
            -webkit-border-radius: 8px;
            -moz-border-radius: 8px;
            font-size: 16px;
            background-color: rgba(0, 0, 0, 0.7);
            /*display: none;*/
        }

        #studentSearch input {
            line-height: normal;
            font-size: 20px;
        }

        #studentList {            
            width: 66%;
            color: #22264B;
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
            width: 80%;
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

    {{-- Script to load student info --}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#button').click(function (e) {
                //if there are any hyphens, remove them.
                var inputvalue =  parseInt($("#input").val().replace(/-/g, ""));
                alert(inputvalue);
                $("#input").val('');
                $('#input').focus();

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
    </script>

    <script>
        $(document).ready(function(){
          $("p").click(function(){
            $(this).hide();
          });
        });
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
                    // if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    if (xmlhttp.status == 200) {
                        document.getElementById("studentList").innerHTML = xmlhttp.responseText;
                       // document.getElementById("studentList").innerHTML = "Abacus";
                    }
                }
                // xmlhttp.open("GET", "studentFind.php?q=" + str, true);
                xmlhttp.open("GET", "studentFind/" + str, true);
                xmlhttp.send();
            }
        }
    </script>

    {{-- Script to pop up sweetalerts --}}
    <script>
        function signin(student) {
            swal({
                title: "Welcome " + student['first'] + " " + student['last'],
                text: "You are signed into room {{$kiosk->room}}",
                icon: "success",
                type:"success",
 		timer:6000
            }).then(
		function() { $('#input').focus() }
	    );
        }
        function signout(student) {
            swal({
                title: "Goodbye " + student['first'] + " " + student['last'],
                text: "You are signed out of room {{$kiosk->room}}",
                icon: "success",
                type:"success",
 		timer:6000
            
		}).then(
		function() { $('#input').focus() }
		);
        }
        function errormsg() {
            swal({
                title: "ERROR!",
                icon: "error",
                text: "The student was not found or there was an unexpected database error.",
                type:"error",
 		timer:6000
            }).then(
	
 	    function() { $('#input').focus() }
        	)};
    </script>
</head>

<body>
    <div class="text-center">

        <!-- html to display student listing -->
        <div id="studentSearch" class="shadow-lg">
            <form class="pure-form">
                <span class="text-light hide">Enter First Name, Last Name, or Student Number...</span>
                <fieldset>
                    <input class="pure-input-2-3" autofocus="" type="text" onkeyup="findStudents(this.value)" placeholder="Enter First Name, Last Name, or Student Number...">
                </fieldset>

                <!-- the student table is created here at "studentList". There is also formatting for this in the css  -->
                <div style="text-align: center;">
                    <div id="studentList"></div>
                </div>
            </form>
        </div>

        <button id="button1" onclick="signout(333444555)">Test of swal()</button><br>

        <img style="margin-top: 10vh; margin-bottom:3vh;" src="{{asset('img/14.png')}}" alt="HB Beal" height="400vh"><br>

        <h1 class="text-center">{{$kiosk->name}}</h1>

        <input type="text" style="text-align: center" id="input" onkeydown="if (event.keyCode === 13) document.getElementById('button').click()"
            autofocus><br>
        <button type="button" id="button">Sign in/out</button>



        <form role="form" action="/terminals/{{ $kiosk->id }}/toggleStudent" method="post">
            <input type="text" style="text-align: center" id="studentID" name="studentID" autofocus><br> {{ csrf_field()
            }}
            <button type="submit">submit - to TerminalController</button>
        </form>


    </div>


</body>

</html>