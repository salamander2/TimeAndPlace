<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/vendor/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('/vendor/sweetalert/sweetalert.min.css') }}">
    <script src="{{asset('/js/sweetalert.min.js') }}"></script> 

<!-- None of this works
    <script src="{{ asset('/vendor/js/jquery.js') }}"></script>
    <script src="{{ asset('/vendor/js/mask.js') }}"></script>
    <script src="{{ asset('/vendor/js/bootstrap.min.js') }}"></script>
-->

    <title>BluePanel Kiosk</title>
    
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

</head>
<body>
<div class="text-center">
        
    <img style="margin-top: 10vh; margin-bottom:3vh;" src="{{asset('img/14.png')}}" alt="HB Beal" height="400vh"><br>
    <h2 class="text-center">{{$kiosk->name}}</h2>
    <input type="text" style="text-align: center" id="input" onkeydown="if (event.keyCode === 13)
                        document.getElementById('button').click()" autofocus><br>
    <button type="button" id="button" onclick="swal('Hello World!')">Sign in/out</button>

</div>


</body>

</html>
