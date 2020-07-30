@extends('blades/index_examen')

@section('title', ' Agregar curso')

@section('content')


<div class="row">
              
        
        @php
            $acumulador=0;  
        @endphp  
        <br/><br/><br/><br/><br/> 
        <div class="col-lg-12"><br/><br/><br/>
            <div class="card" >
                <div class="card-body">

                    @php
                    $acumulador=0; 
                    @endphp


                    @foreach ($this->data["resultado"] as $item)
                    @php
                    $a = explode("-", $item);
                    //echo "cantidad de elementos " . 
                    //print_r($a);
                    if(count($a)==4){
                    $respuesta["respuesta"]=$a[0];
                    $respuesta["valor_respuesta"]=$a[1]; 
                    $respuesta["respuesta_id"]=$a[2];
                    $respuesta["id_usuario"]=$a[3];
                    $acumulador += $a[1]; 
                    $this->db->insert('logevaluacions', $respuesta);
                    //$acumulador = $acumulador + $a[1];





                    }else{
                        $eventousuario_id = $a[0];
                        $intentos = $a[1];
                    }

                    @endphp
                    @endforeach


                    @php 
                       
                        $eventousuario_id = $this->session->userdata["eventousuarios_id"];
                        $actividad_id = $this->data["actividad_id"];

                        $vinculo = "../../curso/evento/" . $this->session->userdata["evento_no"];
                           echo "<H1>Has obtenido una nota de: </H1> <br/> <H2>" . $acumulador . " puntos</H2>";
                           
                          echo "<form action='" .$vinculo .     "'>
                                <input type='submit' value='Aceptar' class='fbtn btn-info'/>
                                </form>";
                                    //me hace falta el tema_id para actualizar
                        
                        $sql = "SELECT * FROM notas WHERE eventousuario_id = $eventousuario_id and tema_id = $actividad_id;";
                        $resultado = $this->db->query($sql);
                        $nota_anterior_en_bd = 0;
                        if($resultado->num_rows() > 0){
                            $fila = $resultado->row();
                            $nota_anterior_en_bd = $fila->nota;
                            } 
                        
                        if($nota_anterior_en_bd > $acumulador){
                          $acumulador = $nota_anterior_en_bd ;
                        }
                        
                        
                        
                        
                        $sql2 = "UPDATE notas SET nota = $acumulador, visto = 1 WHERE eventousuario_id = $eventousuario_id and tema_id = $actividad_id;";
                        $this->db->query($sql2);
                        //print_r($this->session->userdata());
                        
                        $instructor = model('instructor')->get_by('id', model('evento')->get_by('id', $this->session->userdata('evento_id'))->instructor_id);
                        //aqui va el mensaje con la nota para el alumno y el profesor
                        $CI =& get_instance();
                        $asunto = 'Examen Final solventado';
                        $mensaje = 'Haz finalizado el examen, si tu nota ha llegado como mínimo a 70 pts, espera a que se concluya el evento, para que se te envíe tu token de acceso a la constancia de participación.';
                        //echo $mensaje;
                        $CI->enviar_email($asunto, $this->session->userdata('email'), $mensaje);
                        $asunto = 'Examen final solventado';
                        $mensaje = 'El participante: '. model('user')->get_by('email',$this->session->userdata('email'))->first_name .' '.model('user')->get_by('email',$this->session->userdata('email'))->last_name . ', del evento no: '. $this->session->userdata('evento_no') . ' ha realizado el examen final.' ;
                        //echo $mensaje;
                        //$this->enviar_email($asunto, $usuario, $mensaje);
                        $CI->enviar_email($asunto, $instructor->email_instructor, $mensaje);
            
            


                    @endphp
                    





                </div>
            </div>
        </div>
        
        
        
        
    
          
</div>        
        


@section('js_content')

	@includeIf('blades/_js')

@show



@endsection