@extends('layouts.app') 
<script src="{{ asset('/js/jquery.min.js') }}"></script>
@section('content')

<div class="container">
    <div class="row align-middle">
        <div class="col-sm-8">
            <h1>
                Edit Kiosk : {{ $kiosk->name }}
            </h1>
        </div>
        <div class="col text-right">
            <a class="my-1 mx-3 btn btn-warning elevation-3" href="/autosignout/{{ $kiosk->id }}"> Signout all now  </a>
            <a class="my-1 btn btn-success elevation-3" href="/terminals/{{ $kiosk->id }}"> Launch Terminal </a>
        </div>
    </div>

	@if (session('error'))
		<script>
			window.createNotification({
				theme: 'warning',
				positionClass: 'nfc-top-right',
				displayCloseButton: true,
				showDuration: 3500
			})({            
				title:'Success',
				message: '{{ session('error') }}'
			});
		</script>
	@endif

    {{-- top section of edit page --}}
    @include('child.kioskedit1')

    @if($kiosk->autoSignout == true)
        @include('child.kioskedit3')
    @endif

    {{-- bottom section of edit page --}}
    @include('child.kioskedit2')

    <div class="clearfix">
        {{-- onsubmit="return false"  <<< this is needed in case jquery doesnt load.
            Otherwise there is no confirmation and the form is submitted immediately.   --}}
        <form class="float-right" id="formDelete" role="form" onsubmit="return false"
            action="/kiosks/{{ $kiosk->id }}" method="post">
            {{ method_field('DELETE')}} {{csrf_field()}}
            <button id="deleteBtn" type="submit" class="btn btn-danger elevation-3">Delete this Kiosk</button>
        </form>
    </div>
</div>
@endsection

<script>
        $(document).on('submit', '[id^=formDelete]', function (e) {
            e.preventDefault();
            var data = $(this).serialize();
            swal({
                title: "Confirm Deletion of Kiosk {{ $kiosk->name }}",
                text: "Please confirm that you want to delete this kiosk.",                
                className: "bg-warning",
                dangerMode:true,
                buttons:true,                     
                closeOnEsc: true,
                closeOnClickOutside: false
            }).then((confirmed) => {
                if (confirmed) {               
                    formDelete.submit();
                    return true;
                } else {                
                    return false;
                }
            });
            return false;
          });
</script>

<script src="{{ asset('/js/sweetalert.min.js') }}"></script>
