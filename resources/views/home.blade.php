@extends('layouts.app')

@push('homeheader')
    <meta http-equiv="refresh" content="600;url={{ route('home') }}" />
@endpush

 @section('content-header')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Students Signed in (to public kiosks)</h1>
        </div>
        
         {{--  <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>  -->
            <li class="breadcrumb-item active"><i class="fas fa-home"></i>Home</li>
          </ol>
        </div>   --}}

      </div>
    </div>
  </div>
@endsection 

@section('content')

{{--   Listing of all students who are currently signed in to public kiosks.
      1. Divided up by kiosk
      2. Sorted by lastname
      3. Should also include public "PRESENT" status? -- no
    
  --}}
{{-- {!!$request->all() !!}
{{$request->input('password') }}
{{$request->json('password') }}
<p>xxxxxxxxxxxxxxxxxxxxxx</p> --}}
    <div class="container-fluid">
      <div class="row">        
    @foreach($kiosks as $kiosk)
      @php
      $count = $kiosk->signedIn->count()
      @endphp
    <div class="col-lg-6">
      <div class="card card-success">
        <div class="card-header">
          @if ($count > 10) 
            <h3 class="m-0"><a href="home/{{$kiosk->id}}">{{$kiosk->name }}</a></h3>
          @else
          <h3 class="m-0">{{$kiosk->name }}</h3>
          @endif
        </div>       
            
            <div class="card-body" style="padding:0;">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>Student Number</th>
                        <th>Student Name</th>                        
                        <th>TimeStamp</th>
                    </tr>
                    {{-- @foreach($kiosk->signedIn->sortBy('lastname') as $student) --}}
                   
                    @foreach($kiosk->signedIn->sortByDesc('pivot.created_at')->take(10) as $student)
                        <tr>
                            <td>{{$student->studentID}}</td>                            
                            <td>{{$student->lastname}}, {{$student->firstname}}</td>
                            <td>{{$student->pivot->created_at->format('D d M Y - h:i a')}}</td>
                        </tr>
                    @endforeach
                    @if ($count > 10) 
                        <tr class="bg-dark"><td colspan=3 class="text-center"><a href="home/{{$kiosk->id}}"> &lt; more &gt; </a></td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        
@endforeach
  </div>
</div>
{{--  
<div class="callout callout-info">
  <h4>Tip!</h4>

  <p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
      is bigger than your content because it prevents extra unwanted scrolling.</p>
</div>  --}}

{{--  <div class="alert alert-danger"><p>hi</p></div>
<button type="button" class="btn btn-success">hi</button>  --}}

@endsection





