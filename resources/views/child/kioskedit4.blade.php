<!-- child view in kiosk edit to show events and start event terminal -->
<div class="card card-dark ">
    <div class="card-header" data-widget="collapse">
        <h3 class="card-title">Kiosk Events</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" xxdata-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
        </div>
    </div>
    <div class="card-body">
        @if($kiosk->events->count())

        <div class="row my-1" style="border-bottom:solid black 1px;">
            <div class="col-md-3">Name</div>
            <div class="col">Date</div>
            <div class="col">Start Time</div>
            <div class="col">Late Time</div>
            <div class="col">End Time</div>
            <div class="col">&nbsp;</div>
        </div>
        @foreach($kiosk->events as $event)
            <div class="row py-1">
                <div class="col-md-3">
                    <input type="text" class="form-control bg-primary" disabled  value="{{ $event->name }}">
                </div>
                <div class="col">
                    <label>{{$event->date}} </label>
                    {{--  <input type="date" class="form-control border border-info" disabled id="date" name="date" value="{{ $event->date }}">  --}}
                </div>
                <div class="col">
                        {{--  <label>{{$event->startTime}} </label>  --}}
                        <input style="background-color:white;color:black;border:0" type="time"  readonly id="startTime" name="startTime" value="{{ $event->startTime }}"> 
                </div>
                <div class="col">
                        {{--  <label>{{$event->lateTime}} </label>  --}}
                        <input style="background-color:white;color:black;border:0" type="time" readonly id="lateTime" name="lateTime" value="{{ $event->lateTime }}">
                </div>
                <div class="col">
                        {{--  <label>{{$event->endTime}} </label>  --}}
                    <input style="background-color:white;color:black;border:0" type="time" readonly id="endTime" name="endTime" value="{{ $event->endTime }}">
                </div>
                <div class="col">
                    <input type="button" onclick="window.location.href='/'" class="btn  btn-outline-danger"
                        value="Launch Terminal">
                </div>
            </div>
            <!-- end row -->


            {{-- <label class="userlabel" for="user-checkbox-{{ $user->id }}" value="{{$user->id}}">{{ $user->fullname }}</label>
            <input type="checkbox" onchange="window.location.href='/kiosks/{{ $kiosk->id }}/users/{{ $user->id }}'" {{ $user->pivot->isKioskAdmin
            ? 'checked' :''}}>
            <!-- ** NOTE: do not bother with CRSF for this -->
            <label class="userlabel">&nbsp;</label>
            <input type="button" onclick="window.location.href='/kiosks/{{ $kiosk->id }}/detach/{{ $user->id }}'" class="btn btn-outline-danger"
                value="Revoke">
            <br> --}} 
        @endforeach 
        @endif

     



        @if (session('error'))
        <div class="alert alert-success" role="alert">
            {{ session('error') }}
        </div>
        @endif

    </div>
</div>
<!-- end card -->
