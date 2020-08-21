<!-- child view in kiosk edit to handle kiosk user adding and removing -->

<div class="card card-dark collapsed-card">
    <div class="card-header" data-card-widget="collapse">
        <h3 class="card-title">Kiosk Users</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
        </div>
    </div>
    <div class="card-body">
        @if($kiosk->users->count())

        <div class="row my-1" style="border-bottom:solid black 1px;">
            <div class="col-md-2">Name</div>
            <div class="col ">Kiosk Admin?</div>
        </div>
        @foreach($kiosk->users as $user)
            <div class="row py-1">
                <div class="col-md-2 bg-primary">
                    <label for="user-checkbox-{{ $user->id }}" value="{{$user->id}}">{{ $user->fullname }}</label></div>
                <div class="col-md-2">
                    <input type="checkbox" onchange="window.location.href='/kiosks/{{ $kiosk->id }}/users/{{ $user->id }}'" {{ $user->pivot->isKioskAdmin
                    ? 'checked' :''}}>
                    <!-- ** NOTE: do not bother with CRSF for this -->
                </div>
                <div class="col">
                    <input type="button" onclick="window.location.href='/kiosks/{{ $kiosk->id }}/detach/{{ $user->id }}'" class="btn btn-outline-danger"
                        value="Revoke">
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

        <br>
        <Br>


        <h3>Add User</h3>
        <!--<p>** NOTE: do not bother with CRSF for this</p> -->


        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {{-- <label>Select a user and click add</label><br> --}}
                    <select class="bg-secondary form-control" onchange="if (this.value) window.location.href=this.value" size="8">
                    {{--  <select onchange="if (this.value) alert(this.value)" size="8">  --}}
                        <option style="border-bottom:1px solid black;" value="">Click on user to add to kiosk</option>
                        {{--  $kioskusers = KioskUser::where([['kiosk_id', $kiosk->id],['user_id', $user->id]])->get();  --}}
                        {{--  $detachedUsers = Kiosk::where(id, '=', $kiosk->id);  --}}
                        @foreach ( $detachedUsers as $user)
                            
                        
                        {{--  @foreach(\App\User::all() as $user)  --}}
                                {{-- @foreach($detachedUsers as $user) --}}
                                {{-- {{$user->notThisKiosk($kiosk->id) }} --}}
                                <option value="/kiosks/{{ $kiosk->id }}/attach/{{ $user->id }}">{{ucfirst($user->fullname)}}</option>
                            
                        @endforeach
                        
                    </select>

                </div>

            </div>
        </div>


        @if (session('error'))
        <div class="alert alert-success" role="alert">
            {{ session('error') }}
        </div>
        @endif

    </div>
</div>
<!-- end card -->
