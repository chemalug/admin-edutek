@extends('blades/index_examen')

@section('title', ' Agregar curso')

@section('content')
@php
    $curso_no = $this->session->userdata['evento_no'];
    $evento_id = $this->session->userdata['evento_id'];
    $tema_id = $this->data['tema_id'];
    $eventousuario_id = $this->session->userdata['eventousuario_id'];
    $sql_intentos = "SELECT * FROM notas WHERE eventousuario_id = $eventousuario_id and tema_id = $tema_id;";
    $resultado = $this->db->query($sql_intentos);
    $intentos = 0;

    $sql_intento_x_evento = "SELECT * FROM eventos WHERE id = $evento_id;";
    $resultado2 = $this->db->query($sql_intento_x_evento);
    $fila2 = $resultado2->row();
    $intentos_examenes = $fila2->intentos_examenes;




    if($resultado->num_rows() > 0){
        $fila = $resultado->row();
        $intentos = $fila->intentos;
        
    }else{
      
        $sql_insertar = "INSERT INTO notas (nota, eventousuario_id, tema_id,intentos) VALUES( 0, $eventousuario_id, $tema_id, $intentos);";
        $this->db->query($sql_insertar);
        echo "no habia ni una";
        
    }

@endphp

<div class="row">
    
            <div class = "col-md-2"></div>
            <div class="col-md-8 text-center center">
                <div class="card" >
                    <div class="card-body">
                        <h2 class="card-title text-megna">EXAMEN TEORICO  </h2><br><br>
                        <h4 class="card-title">Estas seguro de continuar, si das aceptar contará como un intento</h4>
                    <h4 class="card-title ">Llevas {{$intentos}} de {{$intentos_examenes}} intentos</h4>
                    @if ($intentos >=  $intentos_examenes )
                    <h4 class="card-title text-warning">Ya no cuentas con mas intententos</h4>
                                    @endif<br/><br/>
                        <div class="row">
                            <div class="col-md-6">
                            <form  method="post" action  ="../ver/{{$tema_id}}/{{$intentos}}">
                                    <button type="submit" id="submit" class="btn btn-success waves-effect waves-light m-r-10"  @if ($intentos >=  $intentos_examenes )
                                        disabled
                                    @endif   ><h4>Acepto realizar la prueba</h4></button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                    
                            <form  method="post" action  ="../../curso/evento/{{$curso_no}}"> 
                                    
                                    <button type="submit" id="submit" class="btn btn-danger waves-effect waves-light m-r-10"><h4>No realizaré la prueba</h4></button>
                                </form><br><br><br><br>
                            </div>
                        
                     
                        </div>
                        
                    </div>     
                </div>  
            </div>
    
    </div>
    
    
     

        



@includeIf('blades/_js')


@endsection