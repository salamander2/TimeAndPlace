<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.headLinks')

    @stack('styles')
    @stack('homeheader') <!-- from home.blade.php -->
</head>

<body class="hold-transition skin-blue fixed sidebar-mini">
<div class="wrapper" id="app">
    <header>
        @include('layouts.partials.topNavbar')
    </header>

    {{--  TODO : change sidebar info based on login & roles  --}}
    {{-- EXAMPLE
    <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Left side column. contains the logo and sidebar -->
                @if (Auth::user()->role == "isAdmin")  <--- this no longer works, use auth()->user()->isAdministrator()
                    @include('layouts.sidebar_admin_menu')
                @elseif (Auth::user()->role == "isNormalUser")
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                @endif
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar --> --}}

    {{--  @if(Session::get('guest-url-auth') || Auth::check())  --}}
    {{--  <aside class="main-sidebar">  --}}        
        @include('layouts.partials.sidebar')
        @include('layouts.partials.controlSidebar')
    {{--  </aside>  --}}
    {{--  @endif  --}}

    {{-- where should this go? outside content-wrapper or within? --}}
    @if (session('success'))
		<script>
			window.createNotification({
				theme: 'success',
				positionClass: 'nfc-top-right',
				displayCloseButton: true,
				showDuration: 3500
			})({            
				title:'Success',
				message: '{{ session('success') }}'
			});
		</script>
	@endif
	@if (session('warning'))
		<script>
			window.createNotification({
				theme: 'warning',
				positionClass: 'nfc-top-right',
				displayCloseButton: true,
				showDuration: 3500
			})({            
				title:'Warning',
				message: '{{ session('warning') }}'
			});
		</script>
	@endif
    @if (session('error'))
		<script>
			window.createNotification({
				theme: 'error',
				positionClass: 'nfc-top-right',
				displayCloseButton: true,
				showDuration: 3500
			})({            
				title:'Error',
				message: '{{ session('error') }}'
			});
		</script>
        {{--  <div class="alert alert-danger" role="alert">
	        {{ session('error') }}
	    </div>  --}}
	@endif

    <div class="content-wrapper">
        <section class="content-header">
            @yield('content-header')
        </section>

        <section class="content">
            @yield('content')
        </section>

        
    </div>
    @include('layouts.partials.footer')

</div>

<!-- Scripts -->
@stack('scripts')

</body>
</html>
