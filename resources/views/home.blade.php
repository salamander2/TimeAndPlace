@extends('layouts.app')

@section('content-header')
{{--  From BluePanel  --}}
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Starter Page</h1>
        </div><!-- /.col -->
        
        {{--  <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li>
          </ol>
        </div><!-- /.col -->  --}}

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('content')

        <div class="callout callout-info">
            <h4>Tip!</h4>

            <p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
                is bigger than your content because it prevents extra unwanted scrolling.</p>
        </div>
        <table class="table table-hover">
        @foreach (\App\Kiosk::all() as $kiosk)
        <tr>           
            <td>{{$kiosk->name}}</td>
            <td>{{$kiosk->room}}</td>
            <td><a href="{{'kiosks/'.$kiosk->id.'/edit'}}">
                    <button type="button" style="max-width: 5vw;"
                            class="btn center-block btn-block btn-info">Edit
                    </button>
                </a></td>

        </tr>
        @endforeach
    </table>

            

        

@endsection





