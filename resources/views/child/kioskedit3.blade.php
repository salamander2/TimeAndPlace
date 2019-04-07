@push('scripts')
<script>
    function removeTimeFromKiosk(time) {

        var url = "/kiosks/{{$kiosk->id}}/schedule";
        $.ajax({
            url: url,
            data: {
                time:time
            },
            type: "DELETE",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (result) {
                location.reload();
            }
        });
    }

    function addTimeToKiosk() {
        var timesArray = $("#timeSelectBox").val();
        var i = 0;
        timesArray.forEach(function (val) {
            i++;
            var url = "/kiosks/{{$kiosk->id}}/schedule";
            $.ajax({
                url: url,
                data:{
                  time: val
                },
                type: "POST",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (resp) {
                    if (i = timesArray.length) {
                        location.reload();
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });

        });
    }
</script>
<script>
    var addUserBox = $('.user-add-box').select2();
</script>
@endpush

<div class="card card-dark">
    <div class="card-header">
        <h3 class="card-title">Kiosk schedule</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-arrows-alt-v"></i></button>
        </div>
    </div>
    <div class="card-body">
                
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Kiosk Sign-Out Times</h3>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>                            
                            <th>Periods</th>
                            <th>Begin</th>
                            <th>End</th>
                            
                        </tr>
                        @foreach($periods->sortBy('start') as $period)
                            <tr class="alert alert-primary">                            
                                <td>{{ $period->code }}</td>
                                <td>{{ $period->start }}</td>
                                <td>{{ $period->end }}</td>
                                <td>
                                    <button onclick="removeTimeFromKiosk('{{-- $schedule->time --}}')"
                                            class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>             
                                <th colspan=2>Sign out times:</th>               
                                {{--  <th>End</th>  --}}
                            </tr>
                        @foreach($times->sortBy('end') as $time)
                            <tr class="alert alert-primary">
                                                                
                                <td style="visibility:hidden">{{ $time->end }}</td>
                                <td style="visibility:hidden">{{ $time->end }}</td>                                
                                <td>{{ $time->end }}</td>
                                <td>
                                    <button onclick="removeTimeFromKiosk('{{-- $schedule->time --}}')"
                                            class="btn btn-xs btn-outline-danger"><i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Sign-out Times</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Times selected here will be auto-signout times</label><br>
                                <select class="user-add-box" style="width: 100%;" id="timeSelectBox" name="times"
                                        multiple="multiple">
                                    
                                </select>
                            </div>

                            <button type="button" class="btn btn-block btn-success" onClick="addTimeToKiosk()">
                                Set Times
                            </button>

                            <!-- /.form-group -->

                            <!-- /.form-group -->
                        </div>

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                </div>

            </div>
            
        </div>
    </div>
</div>
<!-- end card -->