@extends('layouts.admin')

@section('title', 'CMCU | devis patient')


@section('content')

    <body>
    <div class="wrapper">
    @include('partials.side_bar')

    <!-- Page Content Holder -->
        @include('partials.header')
  <div class="row" style="text-align:center; pading-top: 50px;">
 
    
        <div class="col-sm-9" style="pading-top: 30px;">
            <img   src="{{ asset('images/' . $devisimages->image)}}" heigth="1000px" width="800px" >
            
            <div style="text-align:center; pading-top: 50px; ">
                <br>
                <h3>NOM DU DEVIS : {{$devisimages->devis_p}}</h3>
            </div>
          
        </div>
        
    </div>
   
   
    </body>

@stop
