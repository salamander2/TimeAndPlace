@extends('layouts.app')




@section('content')

{{--  <ol class="breadcrumb">
	<li><a href="{{route('home')}}"><i class="fas fa-home"></i> Home </a> </li>
	<li class="active"> Kiosks List</li>
</ol>  --}}


<div class="container">
        <h1>My Kiosks</h1>
        <p> UserID: {{ Auth::user()->id }}. Set to edit if isKioskAdmin ELSE set to show only. All have launch terminal though</p>
        @foreach ($my_kiosks as $kiosk)
            <div class="row align-middle">
               
           
                <div class="col-md-4">
                   <a class="btn btn-info elevation-2" href="/kiosks/{{ $kiosk->id }}/edit"> {{ $kiosk-> name }} @ {{ $kiosk-> room }} </a> 
                </div>
                <div class="col-md-2">                   
                   <a class="my-1 btn btn-success elevation-2" href="/terminals/{{ $kiosk->id }}"> Launch Terminal </a>
                </div>
                
            </div>
        @endforeach
    @if($other_kiosks->count())            
    <h1>&nbsp;</h1>
    <h1>All Other Kiosks</h1>
   
    @endif
    
        {{--  @foreach ($kiosks as $kiosk)
        <li>
           <a href="/kiosks/{{ $kiosk->id }}/edit"> {{ $kiosk-> name }} @ {{ $kiosk-> room }} </a> <label>- - - -</label> 
           <a href="/terminals/{{ $kiosk->id }}"> Launch Terminal </a>
        </li>
        @endforeach  --}}

        @foreach ($other_kiosks as $kiosk)
        <div class="row align-middle">
            <div class="col">
                <a class="my-1 btn btn-secondary elevation-2" href="/kiosks/{{ $kiosk->id }}/show"> {{ $kiosk-> name }} @ {{ $kiosk-> room }} </a>
            </div>
        </div>
        
        @endforeach
    
            {{--  <a href="/kiosks/create">Create a new Kisok</a>  --}}
</div>
@endsection
