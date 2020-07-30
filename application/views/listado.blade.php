@extends('blades/index_e')

@section('title', ' Principal')

@section('content')
<div class="row page-titles">
    
</div>

<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3 col-md-6"></div>
            <div class="col-md-6 " >

            <div class="card card-info text-center" style= "background-color:black; color:white; font-size: 18px;">                            
            &nbsp; <br>{{$this->session->userdata['curso_nombre'];}}<br>&nbsp; 
                    
                    <div class="row" >
                      
                  

                               
                    </div>
                    </div>

                <div class="card card-info text-right" style="background-color:transparent;border-style: none;">                            
                    @php                        
                        $banner = model('curso')->get_by('id',$this->session->userdata('curso_id'))->banner;
                    @endphp
                                
                  
                    
                    <div class="row " >
                      
                    <div class="card-title col-lg-12 col-md-12 text-rigth" >   
                    <img src="{{base_url()}}assets/components/img/inicio.png"  width="50px" title="Ir al inicio" onclick="location.href='{{base_url()}}'"  name="inicio" onmouseover="inicio.width='70'" onmouseout="inicio.width='50'" />
                    <img src="{{base_url()}}assets/components/img/lecciones.png" alt="" width="50px" title="Ir a lecciones" onclick="location.href='{{base_url()}}curso/evento/{{$this->session->userdata('evento_no')}}'" name="lecciones" onmouseover="lecciones.width='70'" onmouseout="lecciones.width='50'" />

                               
                    </div>
                    </div>
                    
                </div>                  
        </div> 
    </div> 

<div class="row">
    @php
     $contador = 1; 
     $tipo_card  = "";
    @endphp
@if ($bandera != 1)
    @foreach ($temas as $item)
            @php  
                $eventousuario_id = $this->session->userdata['eventousuarios_id'];
                $tema_id = $item->id;
                $sql = "SELECT visto FROM notas WHERE eventousuario_id = $eventousuario_id AND tema_id = $tema_id;";
                $registros = $this->db->query($sql);
                if($registros->num_rows()==0){
                    $visto = 0;
                }else{
                    $visto = 1;
                }
                
            //Determinar el tipo de card de acuerdo al codigo
           
           switch ($item->es_actividad) {
                case 0:
                   $tipo_card = "card card-inverse card-primary";
                   break;
               
                   case 1:
                   $tipo_card = "card card-inverse card-info";
                   break;
               
                   case 2:
                   $tipo_card = "card card-inverse card-danger";
                   break;

                   case 3:
                   $tipo_card = "card card-inverse card-warning";
                   break;
           }
           
            @endphp





    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 col-md-6"></div>
                <div class="col-lg-6 col-md-6">
                <div class="{{$tipo_card}}">
                            <div class="card-header">
                            <h2 ><a class="text-cyan" href="{{ site_url() }}tema/ver/{{ $item->id }}">
                                @if ($item->es_actividad == '0')
                                    <a class="text-cyan" href="{{ site_url() }}actividad/mostrar_actividad/{{ $item->id }}">
                                    @if (!model('nota')->get_by(['eventousuario_id'=>$this->session->userdata['eventousuarios_id'],'tema_id'=>$item->id]))
                                    <p style="font-size:16px">  <i class="mdi mdi-lightbulb-on-outline"></i> 
                                    @else
                                    <p style="font-size:16px">    <i class="mdi mdi-lightbulb-on text-warning"></i>
                                    @endif
                                     {{ $item->titulo }}
                                @elseif($item->es_actividad == '1')
                                    
                                
                                <!-- Esta es la parte de la condicional, se verifica que exista el registro, mas no que el valor de visto sea uno, lo voy a cambiar. firma: chua -->
                                
                                @if (!model('nota')->get_by(['eventousuario_id'=>$this->session->userdata['eventousuarios_id'],'tema_id'=>$item->id]))
                                     
                                   
                                
                                    <p style="font-size:16px"><i class="mdi mdi-check"></i> 
                                        
                                    @else
                                       <p style="font-size:16px">  <i class="mdi mdi-check text-warning"></i> 
                                    @endif 
                                    {{ $item->titulo }}
                                @elseif($item->es_actividad == '2')
                            
                                <a class="text-cyan" href="{{ site_url() }}evaluacion/confirmar/{{ $item->id }}" style="font-size:16px">
                                    <i class="mdi mdi-book-open"></i>  {{ $item->titulo }}
                                @endif
                                </p>
                            </div>
                            <div class="card-body">
                                <div style="height: 15px;"></div>
                                <p class="card-subtitle"  <p style="font-size:14px; color:white"><b>{{ $item->descripcion }}</b></p>
                            </a></h2>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @endforeach
@endif
</div>
@includeIf('blades/_js')
@endsection