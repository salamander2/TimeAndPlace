@extends('layouts.app')
@section('content-header')


    <h1>

        Create Kiosk
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">Create Kiosk</li>
    </ol>

@endsection
@push('scripts')
@endpush
@section('content')
    <div class="col-lg-6">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kiosk info</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/kiosks" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Kiosk Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Student Success">
                    </div>
                    <div class="form-group">
                        <label for="room">Kiosk Room Number</label>
                        <input type="number" class="form-control" id="room" name="room" placeholder="123">
                    </div>
                </div>

                <!-- /.box-body -->

                <div class="box-footer">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection