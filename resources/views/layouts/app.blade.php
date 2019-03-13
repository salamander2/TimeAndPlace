<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.headLinks')

    @stack('styles')
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper" id="app">
    <header>
        @include('layouts.partials.topNavbar')
    </header>
    {{--  @if(Session::get('guest-url-auth') || Auth::check())  --}}
    {{--  <aside class="main-sidebar">  --}}
        @include('layouts.partials.sidebar')
    {{--  </aside>  --}}
    {{--  @endif  --}}
    <div class="content-wrapper">
        <section class="content-header">
            @yield('content-header')
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>



</div>
@include('layouts.partials.footer')
<!-- Scripts -->
@stack('scripts')

</body>
</html>
