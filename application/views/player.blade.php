@extends('blades/index_e')

@section('title', ' Elearning')

@section('encabezado','Gestor de contenidos')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div style="position: relative;	padding-bottom: 56.25%; /*16:9*/ padding-top: 30px; height: 0;">
            <iframe style="position: absolute;	top: 0;	left: -20px; width: 103%; height: 93%;" src="{{$datos->link}}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
        </div>
    </div>
</div>

<div class="row">

        <div class="col-md-12" >  
                <div class="card card-inverse card-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">{{ $datos->titulo }}</h4></div>
                        <div class="card-body">
                            <h3 class="card-title">Descripción</h3>
                            <p class="card-text">{{ $datos->descripcion }}</p>
                            
                            <div class="row">
                                    <div class="col-md-3 text-left">
                                        @if ($anterior)
                                            <a href="{{ base_url() }}tema/ver/{{ $anterior->id }}" class="btn btn-primary waves-effect waves-light m-r-10" style="width:113px; color:white;" >Anterior</a>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        
                                    </div>
                                    <div class="col-md-3 text-right">
                                        @if (isset($siguiente))
                                            <a href="{{ base_url() }}tema/ver/{{ $siguiente->id }}" class="btn btn-primary waves-effect waves-light m-r-10" style="width:113px; color:white;" >Siguiente</a>
                                        @endif
                                        <br>   &nbsp;  &nbsp; 
                                    </div>
                                </div>
                       </div>
                       
            </div>
        </div>




         
         
         
         
 
    


</div>
@includeIf('blades/_js')
@endsection