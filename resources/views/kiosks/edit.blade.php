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

            @if(!$kiosk->kioskType)
            <a class="my-1 mx-3 btn btn-warning elevation-3" href="/autosignout/{{ $kiosk->id }}"> Signout all now  </a>
	    @endif
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
            @if(!$kiosk->kioskType)
            <a class="my-1 btn btn-primary elevation-3" <a href="{{'/logs/byKiosk/'.$kiosk->id}}"> Show logs </a>
            @else
            <a class="my-1 btn btn-light btn-outline-primary elevation-3" <a href="{{'/reports/'.$kiosk->id}}">Attendance Reports </a>
            @endif
            
            
        {{-- onsubmit="return false"  <<< this is needed in case jquery doesnt load.
            Otherwise there is no confirmation and the form is submitted immediately.   --}}
        <form class="float-right" id="formDelete" role="form" onsubmit="return false"
            action="/kiosks/{{ $kiosk->id }}" method="post">
            {{ method_field('DELETE')}} {{csrf_field()}}
            <button id="deleteBtn" type="submit" class="btn btn-danger elevation-3">Delete this Kiosk</button>
        </form>
    </div>
    <hr>
    @if($kiosk->kioskType)
    {{--  <div class="btn btn-outline-secondary elevation-3">  --}}
    <a class="my-1 btn btn-outline-info elevation-3" <a href="{{'/events/create/'.$kiosk->id}}">Create event</a> (This is only for the dance class performances)
    {{--  </div>  --}}
    @endif
    <br><Br>
    {{-- if there are any events (ie. it is also a signinOnly kiosk)   --}}
    @if($kiosk->events->count())
        @include('child.kioskedit4')
    @endif
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
