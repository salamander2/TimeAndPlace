<!-- child view in kiosk edit to show events and start event terminal -->
<script>
// add Bootstrap tool tips everywhere
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

<div class="card card-dark ">
    <div class="card-header" data-widget="collapse">
        <h3 class="card-title">Kiosk Events</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" xxdata-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
        </div>
    </div>
    <div class="card-body">
        
        <div class="row my-1" style="border-bottom:solid black 1px;">
            <div class="col-md-3">#&nbsp;&nbsp;Name</div>
            <div class="col">Date</div>
            <div class="col">Start Time</div>
            <div class="col">Late Time</div>
            <div class="col">End Time</div>
            <div class="col">&nbsp;</div>
        </div>
        @foreach($kiosk->events->sortBy('date') as $event)
            <div class="row py-1 border border-left-0 border-right-0 border-top-0">
                <div class="col-md-3">
                        {{--  {{$event->id}} <a href="/events/{{$event->id}}/addStudents"><button type="button" class=" btn btn-primary" data-toggle="tooltip" data-placement="top" title="Click to add students to this event">  --}}
                        @if($event->date < now())
                        {{$event->id}}&nbsp;&nbsp;<a href="{{'/events/settings/'.$event->id}}"><button type="button" class="elevation-3 btn bg-info">{{ $event->name }}</button></a>
                        @else
                        {{$event->id}}&nbsp;&nbsp;<a href="{{'/events/settings/'.$event->id}}"><button type="button" class="elevation-3 btn btn-outline-warning bg-info" style="border-width:3px;">{{ $event->name }}</button></a>
                        @endif
                        {{-- {{$event->id}}&nbsp;&nbsp;<span class="btn bg-info">{{ $event->name }}</span> --}}
                        {{-- {{$event->id}}&nbsp;&nbsp;<span class="btn btn-outline-warning bg-info">{{ $event->name }}</span> --}}
                    {{--  <input type="text" class="form-control bg-primary" disabled  value="{{ $event->name }}">  --}}
                </div>
                <div class="col">
            <form>
                    <input type="date" class="border border-secondary" id="date" name="date" value="{{ $event->date }}" required>
                    {{-- <label>{{$event->date}} </label> --}}
                    {{--  <input type="date" class="form-control border border-info" disabled id="date" name="date" value="{{ $event->date }}">  --}}
                </div>
                <div class="col">
                        {{--  <label>{{$event->startTime}} </label>  --}}
                        <input type="time" class="border border-secondary" id="startTime" name="startTime" value="{{ $event->startTime }}" required>
                </div>
                <div class="col">
                        {{--  <label>{{$event->lateTime}} </label>  --}}
                        <input type="time" class="border border-secondary" id="startTime" name="startTime" value="{{ $event->lateTime }}" required>
                        {{-- <input style="background-color:white;color:black;border:0" type="time" readonly id="lateTime" name="lateTime" value="{{ $event->lateTime }}"> --}}
                </div>
                <div class="col">
                        {{--  <label>{{$event->endTime}} </label>  --}}
                        <input type="time" class="border border-secondary" id="startTime" name="startTime" value="{{ $event->endTime }}" required>
                </div>
                <div class="col">
                    {{-- <a href="{{'/events/settings/'.$event->id}}"><button type="button" class="btn btn-outline-danger">Options</button></a> --}}
                    <a href=""><button type="button" class="btn btn-outline-success elevation-2">Update</button></a>&nbsp;&nbsp;
            </form>
                    <a href=""><button type="button" class="btn btn-outline-danger elevation-2"><i class="fas fa-skull-crossbones"></i>&nbsp;</button></a>
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
       

     



        @if (session('error'))
        <div class="alert alert-success" role="alert">
            {{ session('error') }}
        </div>
        @endif

    </div>
</div>
<!-- end card -->
