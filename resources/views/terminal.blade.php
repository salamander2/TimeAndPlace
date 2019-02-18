<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--  <link rel="stylesheet" href="{{ asset('/vendor/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendor/sweetalert/sweetalert.min.css') }}">  --}}
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

    {{--  Script to load student info  --}}
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

    {{--  Script to pop up sweetalerts  --}}
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
        
    <img style="margin-top: 10vh; margin-bottom:3vh;" src="{{asset('img/14.png')}}" alt="HB Beal" height="400vh"><br>
    <h1 class="text-center">{{$kiosk->name}}</h1>
    
    <input type="text" style="text-align: center" id="input" onkeydown="if (event.keyCode === 13)
    document.getElementById('button').click()" autofocus><br>
    <button type="button" id="button">Sign in/out</button>
    <br>
    <button id="button1" onclick="signout(1)">test of swal</button>

    <form role="form" action="/terminals/1/toggleStudent/339654014" method="post">
        {{ csrf_field() }}
        <button type="submit">submit</button>
    </form>
    

</div>


</body>

</html>
