@extends('layouts.app') 
@section('content')

<div class="container">
    <h1>
        Edit Kiosk : {{ $kiosk->name }}
    </h1>
    {{-- top section of edit page --}}
    @include('child.kioskedit')
    {{-- bottom section of edit page --}}
    @include('child.kioskedit2')

    <div class="clearfix">
        <form class="float-right" id="deleteForm" role="form" onclick="return confirmDeletion2()"  action="/kiosks/{{ $kiosk->id }}" method="post">
            {{ method_field('DELETE')}} {{csrf_field()}}
            <button type="submit" class="btn btn-danger">Delete this Kiosk</button>
        </form>
    </div>
</div>
@endsection

<script>
   // function confirmDeletion(){
   
        $(document).on('submit', '#deleteForm', function (e) {
            alert("hi");
            e.preventDefault();
            var data = $(this).serialize();
            swal({
                title: "Are you sure?",
                text: "Do you want to Send this email",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, send it!",
                cancelButtonText: "No, cancel pls!",
            }).then(function () {
                $('#deleteForm').submit();
            });
            return false;
        });
   
</script>
<script>
    function confirmDeletion2() {        
        alert(jquery().jquery);
        swal({
            title: "Confirm Deletion of Kiosk {{ $kiosk->name }}",
            text: "Please confirm that you want to delete the \"{{ $kiosk->name }}\" kiosk.",                
            className: "bg-warning",
            dangerMode:true,
            buttons:true,
        })
        .then((confirmed) => {
            if (confirmed) {               
                form.submit();
                return true;
            } else {                
                return false;
            }
        });
        return false;
    }
/*
            swal({
                title: "Confirm Kiosk Deletion",
                text: "Please confirm that you want to delete the {{ $kiosk->name }} kiosk.",
                icon: "danger",
                buttons: true,
                dangerMode: true,
                })
                .then((confirmed) => {
                if (confirmed) {
                    return true;
                } else {
					return false;
				}
                });
        }
   */

</script>
<script src="{{ asset('/js/sweetalert.min.js') }}"></script>