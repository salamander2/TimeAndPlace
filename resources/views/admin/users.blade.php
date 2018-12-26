@extends('layouts.app')
@section('content-header')


    <h1>
        Users
        <small>All registered users on the system.</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>

@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Users</h3>
                    <div class="input-group input-group-sm pull-right">
                        <a href="{{route('users.create')}}">
                            <button type="button" class="btn btn-sm btn-primary"
                                    style="border-radius: 0 3px 3px 0;margin-left:-1px;">Create New
                            </button>
                        </a>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Administrator</th>
                            <th>Created</th>
                            <th></th>
                        </tr>
                        @foreach (\App\User::all() as $user)
                            <tr>
                                <td><code>{{$user->id}}</code></td>
                                <td><a href="{{route('users.edit', $user->id)}}">{{$user->username}}</a></td>
                                <td><a href="{{route('users.edit', $user->id)}}">{{$user->email}}</a></td>
                                <td>{{ucfirst($user->name_last)}}, {{ucfirst($user->name_first)}}</td>
                                <td><code>{{$user->isadmin ? 'true' : 'false'}}</code></td>
                                <td>{{$user->created_at}}</td>
<!-- remove avatar
                                <td class="text-center"><img src="https://s.gravatar.com/avatar/{{md5( strtolower( trim( $user->email ) ) )}}?s=100" style="height:20px;" class="img-circle"></td>
-->
			   </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
