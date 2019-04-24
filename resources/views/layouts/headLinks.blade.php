
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Tell the browser to be responsive to screen width -->
{{--  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  --}}

<!-- Scripts -->
{{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
<!-- adding defer means that it loads last and so jQuery wont be there for when the page first loads -->
<script src="{{ mix('js/app.js') }}" ></script>

<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
{{--  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">  --}}

<!-- Styles -->
<link href="/css/app.css" rel="stylesheet">
<link href="/css/notifications.css" rel="stylesheet">

<style>
    .userlabel {
        /* used for userMaint page to get table like effect using labels */
        width:20%;  display: inline-block;
    }
    #showKiosk input[type="checkbox"]:disabled:checked  {
        outline:2px solid blue;
        outline-offset: -2px;
        color:black;
    }
     


    
    
</style>
{{--  
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{asset('vendor/adminlte/bootstrap/dist/css/bootstrap.min.css')}}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('vendor/adminlte/font-awesome/css/font-awesome.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{asset('vendor/adminlte/Ionicons/css/ionicons.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('vendor/adminlte/css/AdminLTE.min.css')}}">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{asset('vendor/adminlte/css/skins/skin-blue.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/adminlte/select2/dist/css/select2.min.css')}}">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- SweetAlert-->
<link rel="stylesheet" href="{{asset('vendor/sweetalert/sweetalert.min.css')}}">
<!-- Datatables CSS -->
<link rel="stylesheet" href="{{asset('vendor/adminlte/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
<!-- Custom CSS -->
<link rel="stylesheet" href="{{asset('/css/style.css')}}"> 
 --}}
