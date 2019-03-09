<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/sweetalert/sweetalert.min.css')}}">
    <title>BluePanel Kiosk</title>
    <script src="{{ asset('/vendor/js/jquery.js') }}"></script>
    <script src="{{ asset('/vendor/js/mask.js') }}"></script>
    <script src="{{ asset('/vendor/js/bootstrap.min.js') }}"></script>
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
        button[type=button], input[type=submit], input[type=reset] {
            background-color: #121117;
            border: none;
            color: white;
            padding: 14px 32px;
            text-decoration: none;
            margin: 3px 2px;
            cursor: pointer;
        }
        
    </style>
<!-- TODO: Fix Cameron's horrible skidded code from stackoverflow -->

    <script type="text/javascript">
        $(document).ready(function () {
            $("#txtboxToFilter").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl/cmd+A
                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: Ctrl/cmd+C
                    (e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: Ctrl/cmd+X
                    (e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        });
    </script>
    <script>
        jQuery(function ($) {
            $("#input").mask("999-999-999", {placeholder: " "});//Auto Formatting
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#button').click(function (e) {
                var inputvalue =  parseInt($("#input").val().replace(/-/g, ""));
                $("#input").val('');
                $('#input').focus();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    async: true,
                    url: '/kiosks/{{$kiosk->id}}/togglestudent/' + inputvalue,
                    dataType: "json",
                    contentType: "application/json",
                    success: function (msg) {
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
                        console.log(err);
                        errormsg();
                    }
                });
            });
        });
    </script>
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
    <script src="{{asset('/vendor/sweetalert/sweetalert.min.js')}}"></script>
</head>
<body>
<div class="text-center">
    <img style="margin-top: 10vh; margin-bottom:3vh;" src="{{asset('img/14.png')}}" alt="HB Beal" height="400vh"><br>
    <h2 class="text-center">{{$kiosk->name}}</h2>
    <input type="text" style="text-align: center" id="input" onkeydown="if (event.keyCode === 13)
                        document.getElementById('button').click()" autofocus><br>
    <button type="button" id="button">Sign in/out</button>

</div>


</body>

</html>
