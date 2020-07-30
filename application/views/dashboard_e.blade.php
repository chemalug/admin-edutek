
@extends('blades/index_e')

@section('title', ' Principal')

@section('content')





<div class="row page-titles">



</div>
<div class="row">
@if ($bandera == 1)
    @foreach ($eventos as $evento)
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    @php
                         $evento->id;
                        $data = model('evento')->get_by('id',$evento->evento_id);
                        //area de declaraciones chuita
                        $evento_id = $data->id;
                        $curso_id = $data->curso_id;
                        $data2 = model('curso')->get_by('id',$curso_id);
                        $curso_nombre = $data2->nombre;
                        $curso_descripcion = $data2->descripcion;
                        
                        $user_id = $user->id;
                         $sql = 'select id from eventousuarios where user_id = ' . $user_id . ' and ' .
                                'evento_id = ' . $evento_id . ';';
                        
                        $eventousarios = $this->db->query($sql);
                        $fila = $eventousarios->row();
                        $eventousuario_id = $fila->id;

                        $sql2 = 'SELECT sum(nota) as nota FROM eventos JOIN cursos on eventos.curso_id = cursos.id 
                                JOIN leccions on leccions.curso_id = cursos.id
                                join temas on leccions.id = temas.leccion_id join notas on temas.id =  
                                notas.tema_id where notas.eventousuario_id = '. $eventousuario_id .'  
                                and eventos.id = '. $evento_id .';';
                        $resultado = $this->db->query($sql2);  
                        $resultado = $resultado->row();
                        $nota =  $resultado->nota;
                        //CALCULOS NECESARIOS PARA LOS TRABAJOS CON FECHAS
                        //para ver la duracion del evento vamos ver la fecha de inicio, fecha fin, fecha de hoy y hacer una regla de tres del 100%
                        // para el progress bar
                        $resultado = $this->db->query("SELECT * FROM eventos WHERE id = $evento_id");
                        $fila = $resultado->row();
                        $fecha_inicio = $fila->fecha_inicio;
                        $fecha_final = $fila->fecha_final;
                        //$duracion = $fecha_inicio - $fecha_final;
                        
                        $f1 = new DateTime($fecha_inicio);
                        $f2 = new DateTime($fecha_final);
                        $hoy = new DateTime(date("Y-m-d"));
                        $estado_evento = "En ejecución";
                        $this->session->set_userdata('estado_evento',$estado_evento);
                        
                        $duracionTotal = $f2->diff($f1);
                        $diastotales= $duracionTotal->days;
                        $remanente    = $f2->diff($hoy);
                        //chapus agregando uno a remantente
                        $diasquefaltan = $remanente->days+1;
                        
                        
                        if($f2 == $f1){
                           
                        $porcentaje = 100;

                        }else{
                        $porcentaje = $remanente->days * 100 / $duracionTotal->days ;
                        $porcentaje = 100 - $porcentaje;
                        }


                        if($f2 < $hoy){
                            $diasquefaltan = 0;
                            $estado_evento = "Finalizado";
                            $porcentaje = 100;
                            
                        }

                        if($f2 == $hoy){
                            $diasquefaltan = 0;
                            $estado_evento = "Finalizado";
                            $porcentaje = 100;
                            


                        }

                        $porcentaje = round($porcentaje,1);
                        
                        
                        $fecha_inicio = date("d-m-Y", strtotime($fecha_inicio));
                        $fecha_final = date("d-m-Y", strtotime($fecha_final));



                    @endphp

                    
                    @if ($estado_evento == "En ejecución")
                            <a href="{{ site_url() }}curso/evento/{{ $data->no_evento }}">    
                            @else

                    @endif
                    
                        <div class="row">
                            
                            @php
                                $curso_id = 0;
                                $logo = "";
                                $no_evento= $data->no_evento;
                                $sql1 = "SELECT * FROM eventos WHERE no_evento = '$no_evento';";
                                $res1 = $this->db->query($sql1);

                                if($res1->num_rows() > 0){
                                    $fila1 = $res1->row();
                                    $no_curso = $fila1->curso_id;
                                
                                    $sql2="SELECT * FROM cursos WHERE id = $no_curso;";
                                    $res2 = $this->db->query($sql2);
                                    $fila2 = $res2->row();
                                    $imagen = $fila2->logo;
                                }
                            @endphp
                            <div class="col-12 inner" style="height:525px;">
                            <div ><img class="img-responsive" src="{{ $imagen }}" ></div>
                                
                                
                                <h3 class="text-center" >{{$curso_nombre}}</h3> <h4 class='text-center'> {{ $data->no_evento }}</h4><br/>
                             <p style="color:white;">Descripción del curso:</p>
                            <div style="height:200px;overflow-y: auto;padding:5px;background-color:#263238;" class="scroll"><h6 class="card-subtitle" style="color:white;">{{$curso_descripcion}}</h6></div>
                            
                            
                           
                            </div>
                            <div class="col-12 small-box">
                                @php  //el progreso del evento se pasa  por data eventos
                                @endphp
                                
                                    <h6 style="padding-top:10px" >Punteo: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <b>{{ $nota }}</b> </h6>
                                    <!--Esta es la parte en la cual se evalua si el eveto ya termino -->
                               
                                    <span style="color:white;">
                                        <i class=" text-success mdi mdi-book-variant"> </i> {{$estado_evento}};
                                    </span>
                                    @if ($diasquefaltan > 0)
                                    <h6 style="padding-top:15px">Dias para finalizar el evento: &nbsp &nbsp <br><center> <b> {{$diasquefaltan}}</b></center></h6>
                                    <!-- Calculo para el avance del curso en base a las actividades realizadas -->
                                    @endif

                                    @php 



                                      $sqlactividadestotales = "SELECT count(*) as numero FROM temas JOIN leccions ON temas.leccion_id = leccions.id WHERE leccions.curso_id = $curso_id;";                                    
                                      $sqlactividadesvistas  = "SELECT count(*) as numero FROM notas JOIN temas ON temas.id = notas.tema_id JOIN leccions ON temas.leccion_id = leccions.id WHERE eventousuario_id = $eventousuario_id;";


                                     $resultado1 = $this->db->query($sqlactividadestotales);
                                     $resultado2 = $this->db->query($sqlactividadesvistas);
                                     
                                    if($resultado1->num_rows() > 0){
                                        $fila = $resultado1->row();
                                        $actividadestotales = $fila->numero; 
                                     }else{
                                    $actividadestotales = 0;
                                    }

                                    if($resultado2->num_rows() > 0){
                                        $fila = $resultado2->row();
                                        $actividadesvistas = $fila->numero; 
                                     }else{
                                    $actividadesvistas = 0;
                                    } 
                                     
                                    if($actividadestotales !=0) {
                                        $porcentaje = $actividadesvistas * 100 / $actividadestotales;

                                    }
                                    
                                    $porcentaje = round($porcentaje, 1);
                                                                   
                                    if ($porcentaje < 0) 
                                     $porcentaje = 0;

                                    @endphp


                                    <div >
                                    @php
                                    $query = "Select carnet from users where id = '$user_id';";
                                    $resultado = $this->db->query($query);
                                    $carnet = "";
                                    if($resultado->num_rows() > 0){
                                    $fila = $resultado->row();
                                    $carnet = $fila->carnet;
                                    }else{
                                    
                                    } 



                                    $query = "Select token from intecapt_constancias.verificacions where evento_id = $evento_id and carnet = '$carnet';";
                                    $resultado = $this->db->query($query);
                                    $token = "";
                                    if($resultado->num_rows() > 0){
                                    $fila = $resultado->row();
                                    $token = $fila->token;
                                    }else{
                                    $token = "El instructor generará los certificados de participación al finalizar el evento";
                                    } 

                                    

                                    
                                    
                                        
                                    @endphp

                                    
                                    <br>
                                    <p style="color:white">Código de validacion:  <h6>{{ $token }}</h6></p>
                                    <a href="http://intecap.tech/verificacion/verify" style="font-size:15px;">Verfica tu certificado aquí</div>
                                    
                                
                                
                            </div>
                        </div>
                    
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@else
<!--  Para el detalle de los cursos por unidad-->
<div class="col-lg-12">
    <div class="row">
        <div class="col-lg-3 col-md-6"></div>
            <div class="col-md-6 text-right " >
                                        
                   
                               
                    
                    <
                    @php
                        $evento_id= $this->session->userdata('evento_id');
                        $dosificacion  = model('evento')->get_by('id',$evento_id)->dosificacion;
                    @endphp
                    <div class="card card-info text-center" style= "background-color:black; color:white; font-size: 18px;">                            
            &nbsp; <br>{{$this->session->userdata['curso_nombre'];}}<br>&nbsp; 
                    
                    
                    </div>
                    <div class="card-title col-lg-12 col-md-12 text-right" >   

                    

                    <img src="{{base_url()}}assets/components/img/inicio.png" title="Ir a Inicio" width="50px" title="" onclick="location.href='{{base_url()}}'" name="inicio" onmouseover="inicio.width='70'" onmouseout="inicio.width='50'" />
                    <img src="{{base_url()}}assets/components/img/normativo.png"  title="Ver el nomrmativo del participante"  width="50px" title="" onclick="window.open('{{base_url()}}assets/normativo.pdf','newwindows','width=800,height=750'); " name="normativo" onmouseover="normativo.width='70'" onmouseout="normativo.width='50'" />
                    <img src="{{base_url()}}assets/components/img/dosificacion.png" title="Ver la dosificación del curso"  width="50px" title="" onclick="window.open('{{base_url()}}{{$dosificacion}}','newwindows','width=800,height=750'); " name="dosifica" onmouseover="dosifica.width='70'" onmouseout="dosifica.width='50'"/>

                              
                                
                    </div>
                    </div>
                    
                </div>                  
        </div> 
    </div> 
                



@foreach ($contenidos as $item)
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 col-md-6"></div>
                <div class="col-lg-6 col-md-6">
                    <div class="card card-inverse card-info">
                        <div class="">
                            
                            <a href="{{ site_url() }}curso/leccion/{{ $item->id }}">    
                            
                                @php  
                                $evento_id = $this->session->userdata['evento_id'];
                                $user_id = $this->session->userdata['usuario_id'];     
                                $leccion_id = $item->id;
                                @endphp
                            
                                
                           
                            
                           
                            
                                <div class="row">
                                    <div class="col-12 ">
                                    </div>
                                    <div class="col-12 card-title">
                                      <div class="text-center card-header col-12" style="font-size:17px"><b>{{ $item->titulo }}</b></div>
                                     <div class="card-body" style="font-size:18px">
                                        <h6 class="text-left"><u>Descripción</u></h6>   
                                        <h6 class="text-left">{{ $item->descripcion }}</h6>
                                        <h6 class="text-left">Duración recomendada: {{ $item->duracion }} hrs</h6>
                                    
                                    
                                        @php  //calculo del avance por leccion
                                        $curso_id = $this->session->userdata['curso_id'];
                                        $sql = "SELECT * FROM eventos WHERE eventos.no_evento = '$evento_no';";
                                        $resultset = $this->db->query("$sql");    
                                        $fila = $resultset->row();
                                        $evento_id = $fila->id;
                                        //calculo del eventousuarios
                                        $sql = 'select id from eventousuarios where user_id = ' . $user_id . ' and ' .
                                        'evento_id = ' . $evento_id . ';';
                        
                                        $eventousarios = $this->db->query($sql);
                                        $fila = $eventousarios->row();
                                        $eventousuario_id = $fila->id;
                                        //necesito el evento_id y tengo el evento_no
                                        
                                        $this->session->set_userdata('eventousuario_id',$eventousuario_id);

                                       $sql = 'SELECT sum(notas.nota) as nota FROM eventousuarios JOIN notas ON 
                                        eventousuarios.id = notas.eventousuario_id JOIN temas on notas.tema_id = temas.id 
                                       JOIN leccions ON leccions.id = temas.leccion_id WHERE evento_id = '. $evento_id .' 
                                       and eventousuarios.id = ' . $eventousuario_id .' and leccions.id = ' . $item->id . ';';
                                        $consulta = $this->db->query($sql);
                                       $fila = $consulta->row();
                                        $nota_leccion = $fila->nota;
                                        $nota_leccion;
                                        if(!isset($nota_leccion)){
                                            $nota_leccion = 0;

                                        }
                                       /* $sql3 ="SELECT sum(punteo) as totalpunteo FROM temas WHERE temas.leccion_id = $leccion_id;";
                                        $datos3 = $this->db->query($sql3);
                                        $fila3 = $datos3->row();
                                        $nota_total_leccion = $fila3->totalpunteo;
                                        $porcentaje_de_nota = $nota_leccion * 100 / $nota_total_leccion;

                                        $porcentaje_de_nota = round($porcentaje_de_nota,1);*/

                                        



                                         $sql4 = "SELECT count(*) as total  FROM temas JOIN leccions  on temas.leccion_id = leccions.id where
                                        leccion_id = $leccion_id ;";
                                        $datos4 = $this->db->query($sql4);
                                        $fila4 = $datos4->row();
                                        $total_videos = $fila4->total;


                                         $sql5 = "SELECT count(*)  as total FROM temas join notas on temas.id = notas.tema_id where 
                                        notas.eventousuario_id = $eventousuario_id and leccion_id = $leccion_id and notas.visto = 1;";
                                        $datos5 = $this->db->query($sql5);
                                        $fila5 = $datos5->row(); 
                                        $total_videos_vistos = $fila5->total;

                                        // ahora los videos son las tareas: video, actividad o examen
                                        if($total_videos == 0){
                                            $porcentaje_de_nota = 0;
                                        }else{
                                        $porcentaje_de_nota = $total_videos_vistos * 100 / $total_videos; 
                                            }

                                        //echo "TOTAL VIDEOS: " . $sql4 . "**** $total_videos ******";
                                        //echo "TOTAL VIDEOS VISTOS: " . $sql5 ."***** $total_videos_vistos" ;



                                        @endphp
                                        <h6 class="text-center" style="color:white; ">Has realizado un total de {{$total_videos_vistos}} de  {{$total_videos}} tareas </h6>
                                        
                                        
                                            <div class="progress" style="">
                                            <div class="progress-bar " role="progressbar" style="width: @php $porcentaje_de_nota = round($porcentaje_de_nota, 1); @endphp {{ $porcentaje_de_nota }}% ; height: 35px; background-color:#00cc00;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="25">
                                                <h4><b>{{ $porcentaje_de_nota }}%</b></h4>
                                            </div>
                                            </div>
                                            
                                    </div>
                            
                            </a>
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