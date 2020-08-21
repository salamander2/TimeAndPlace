{{-- The blade page for creating kiosks is admin.createKiosk --}}
{{-- kiosk types: I haven't changed the table over to strings yet. It's still tinyint()
     0 = signin/out
     1 = attendance only // meetings
     2 = events: on-time/late/absent
 --}}

@extends('layouts.app') 
@section('content')

<div class="container">
    <div class="row align-middle">
        <div class="col-sm-8">
            <h1>
                Edit Kiosk : {{ $kiosk->name }}
            </h1>
        </div>
        <div class="col text-right">

            @if($kiosk->kioskType == 0)
                <a class="my-1 mx-3 btn btn-warning elevation-3" href="/autosignout/{{ $kiosk->id }}"> Signout all now  </a>
            @endif
            @if($kiosk->kioskType != 2)
                <a class="my-1 btn btn-success elevation-3" href="/terminals/{{ $kiosk->id }}"> Launch Terminal </a>
            @endif
        </div>
    </div>

    {{-- top section of edit page: KIOSK SETTINGS ... used for all kiosk types --}}
    @include('child.kioskedit1')

    {{-- Kiosk schedule sub menu .. only type 0 --}}
    @if($kiosk->kioskType==0 && $kiosk->autoSignout == true)
        @include('child.kioskedit3')
    @endif

    {{-- kiosk users ... all kiosk types --}}
    @include('child.kioskedit2')

    <div class="clearfix">
            @if($kiosk->kioskType==0)
                <a class="my-1 btn btn-primary elevation-3" href="{{'/logs/byKiosk/'.$kiosk->id}}"> Show logs </a>
            @endif
            @if($kiosk->kioskType==1)
                <a class="my-1 btn btn-light btn-outline-primary elevation-3" href="{{'/reports/attend/'.$kiosk->id}}">Attendance Reports </a>
            @endif
            @if($kiosk->kioskType == 2)
            {{--  <div class="btn btn-outline-secondary elevation-3">  --}}
                <a class="my-1 btn btn-outline-primary elevation-3" href="{{'/events/create/'.$kiosk->id}}">Create event</a>
            {{--  </div>  --}}
            @endif
            
            
         @if (auth()->user()->isAdministrator())
            {{-- onsubmit="return false"  <<< this is needed in case jquery doesnt load.
            Otherwise there is no confirmation and the form is submitted immediately.   --}}
            <form class="float-right" id="formDelete" role="form" onsubmit="return false"
                action="/kiosks/{{ $kiosk->id }}" method="post">
                {{ method_field('DELETE')}} {{csrf_field()}}
                <button id="deleteBtn" type="submit" class="btn btn-danger elevation-3"><i class="fas fa-skull-crossbones"></i> Delete this Kiosk <i class="fas fa-skull-crossbones"></i></button>
            </form>
        @endif
    </div>

    <br><br>
    {{-- if it is a signinOnly kiosk and there are any events   --}}
    @if($kiosk->kioskType == 2 && $kiosk->events->count())
        @include('child.kioskedit4') {{-- Events for kiosktype=2 --}}
    @endif
</div>
@endsection

@push('scripts')
<script>
        $(document).on('submit', '[id^=formDelete]', function (e) {
            e.preventDefault();
            var data = $(this).serialize();

	  Swal.fire({
              title: "Confirm Deletion of Kiosk {{ $kiosk -> name }}",
              text: "Please confirm that you want to delete this kiosk.",
              customClass: {popup: "bg-warning"},
		  icon: 'error',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Yes, delete it!'
		}).then((confirmed) => {
                if (confirmed.value) {               
                    formDelete.submit();
                    return true;
                } else {                
                    return false;
                }
		});

            return false;
          });
</script>
@endpush

{{-- <script src="{{ asset('/js/sweetalert.min.js') }}"></script> --}}
