@extends('layouts.app') 
<script src="{{ asset('/js/jquery.min.js') }}"></script>
@section('content')

<div class="container">
    <h1>
        Edit Kiosk : {{ $kiosk->name }}
    </h1>
    {{-- top section of edit page --}}
    @include('child.kioskedit1')

    @if($kiosk->autoSignout == true)
        @include('child.kioskedit3')
    @endif

    {{-- bottom section of edit page --}}
    @include('child.kioskedit2')

    <div class="clearfix">
        {{-- onsubmit="return false"  <<< this is needed in case jquery doesn't load.
            Otherwise there is no confirmation and the form is submitted immediately.   --}}
        <form class="float-right" id="formDelete" role="form" onsubmit="return false"
            action="/kiosks/{{ $kiosk->id }}" method="post">
            {{ method_field('DELETE')}} {{csrf_field()}}
            <button id="deleteBtn" type="submit" class="btn btn-danger">Delete this Kiosk</button>
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