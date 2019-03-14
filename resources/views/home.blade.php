@extends('layouts.app')

@section('content-header')
{{--  From BluePanel  --}}
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Students Signed in (to public kiosks)</h1>
        </div><!-- /.col -->
        
         <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li>
          </ol>
        </div><!-- /.col -->  

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
@endsection

@section('content')

    <div class="container-fluid">
      <div class="row">        
    @foreach(App\Kiosk::all()->where('publicViewable','=','1') as $kiosk)
    <div class="col-lg-6">
      <div class="card card-success">
        <div class="card-header">
          <h3 class="m-0">{{$kiosk->name }}</h3>
        </div>       
            
            <div class="card-body" style="padding:0;">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>Student Number</th>
                        <th>Student First</th>
                        <th>Student Last</th>
                        <th>TimeStamp</th>
                    </tr>
                    @foreach($kiosk->signedIn as $student)                     
                      
                        <tr>
                            <td>{{$student->studentID}}</td>
                            <td>{{$student->firstname}}</td>
                            <td>{{$student->lastname}}</td>
                            <td>{{$student->pivot->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
@endforeach
  </div>
</div>

<div class="callout callout-info">
  <h4>Tip!</h4>

  <p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
      is bigger than your content because it prevents extra unwanted scrolling.</p>
</div>

{{--  <div class="alert alert-danger"><p>hi</p></div>
<button type="button" class="btn btn-success">hi</button>  --}}


@endsection





