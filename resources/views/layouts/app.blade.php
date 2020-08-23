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

		@include('layouts.partials.sidebar')
		@include('layouts.partials.controlSidebar')


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
