
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

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
<link href="/css/myStyle.css" rel="stylesheet">

