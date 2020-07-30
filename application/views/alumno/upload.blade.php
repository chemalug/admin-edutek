@extends('blades/index_e')

@section('title', ' Agregar Instructor')


@section('content')

@php  

    $id_actividad = $this->data["tema_id"] ;
    //$usuario = $this->session->userdata["identity"];
   
    

@endphp

<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                
        
                
                    
                        <div class="form-group">
                            <div class="card-body" style="background-color:#222526;text-align: center "> 
                            <label for="exampleInputuname" style="color:white" ><h2>Actividad: @php echo $this->data["actividad_titulo"]  @endphp</h2></label><br/>
                            </div>
                            <div class="card-body">
                            </div>

                            <div class="card-body" style="background-color:#222526;">
                            <label for="exampleInputuname" style="color:white"><h3>Descripcion:  </h3> @php echo $this->data["actividad_descripcion"]  @endphp</label><br/>
                            <label for="exampleInputuname" style="color:white">Punteo:  @php echo $this->data["actividad_punteo"]  @endphp </label>
                            </div>
                            
                            

                            @if($this->data['actividad_archivo']!='../')
                            <div class="card-body">
                                </div>
                            <div class="card-body" style="background-color:#222526;">
                            <label for="exampleInputuname" style="color:white"><h3>Recurso: </h3><a href="{{'../' . $this->data['actividad_archivo']}}">Descarga el archivo de la actividad el cual contiene las instrucciones a seguir. <i class="mdi mdi-briefcase-download"></i>  </a></label>
                            </div>
                            
                            <div class="card-body">
                                </div>
                            <div class="input-group">
                                <div class="input-group-prepend">

                                </div>

                                @endif

                                @php
                                
                                if($this->data["actividad_punteo"]==0){

                                $user_id =  $this->session->userdata("user_id");
                                $id_evento =  $this->session->userdata("evento_id");
                                $id_actividad;
                                $eventousuarios_id = $this->session->userdata("eventousuarios_id");

                                $now = new DateTime();
                                $fechaSQL = $now->format('Y-d-m');
                                $hora = $now->format('H:i:s');
                                // consultar la base de datos
                                $es_actividad =  $this->input->post("es_actividad");
                                $datos_log_general = array(
                                "usuario" => $usuario, "tema_id" => $tema_id, "fecha" => $fechaSQL, "hora" => $hora);
                                model('log_general')->insert($datos_log_general);

                                $registro = $this->db->query("SELECT id,intentos FROM archivos_temas WHERE tema_id = $tema_id and usuario = '$usuario';");
                                $a = $registro->result_array();
                                $intentos = 1;        

                                if (count($a) > 0) {
                                foreach ($registro->result() as $row) {
                                $intentos =  1;
                                $id =$row->id;
                                $datos_update_datos_temas = array("usuario" => $usuario, "tema_id" => $tema_id, "archivo" => $full_path, "intentos" => $intentos, 
                                "evento_no"=>$this->session->userdata('evento_no'), "eventousuario_id"=>$this->session->userdata('eventousuarios_id'));
                                model('archivos_tema')->update($id,$datos_update_datos_temas);}              
                                }else{
                                $intentos = 1;
                                $datos_archivos_temas = array("usuario" => $usuario, "tema_id" => $tema_id,  "intentos" => $intentos, 
                                "evento_no"=>$this->session->userdata('evento_no'), "eventousuario_id"=>$this->session->userdata('eventousuarios_id'));
                                
                                $eventousuarios_id = $this->session->userdata('eventousuarios_id');

                                //instrucciones SQL para ver si existe el registro, si existe lo actualiza y si no lo inserta.    
                                $sqlnota1 = "SELECT * FROM notas WHERE eventousuario_id ='" . $eventousuarios_id . "' AND tema_id = '" . $tema_id ."'";
                                $sqlnota2 = "UPDATE notas SET visto = 1 WHERE eventousuario_id ='" . $eventousuarios_id . "' AND tema_id = '" . $tema_id ."'";
                                $sqlnota3 = "INSERT INTO notas(nota, eventousuario_id,tema_id, visto) VALUES(0,$eventousuarios_id,$tema_id,1)";

                                $result1 = $this->db->query($sqlnota1);

                                $cantidadfilas = $result1->num_rows();


                                if($cantidadfilas == 0 ){
                                    $this->db->query($sqlnota3);

                                }else{

                                    $this->db->query($sqlnota2);

                                }



                                }

                                //endif
                                }



                                @endphp




                                @if($this->data["actividad_punteo"]!=0)
                                <div class="card-body" style="background-color:#222526;">
                                        <label for="exampleInputuname" style="color:white"><h3>Subir tarea:</h3></label><br/>
                                        <label for="exampleInputuname" style="color:white">Una vez terminada la tarea debes subirla en este apartado, debe ser un archivo o una carpeta comprimida en formato .zip con varios archivos.
                                        <br><br>
                                     <p style="color:#9fdc0a";><b>El nombre del archivo o archivo comprimido, NO debe contener caracteres especiales, ni espacios, solamente letras y números</b></p></label><br/>
                                    <form name="form1" action="../subir_archivo" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="tema_id" value="{{$this->data['tema_id']}}">
                                    <input type="hidden" name="es_actividad" value="{{$this->data['es_actividad']}}">
                                  
                                  
                                  
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="archivo" name="archivo"  value="">
                                        <label class="custom-file-label form-control" for="imagen" aria-describedby="imagen">Seleccione un archivo</label>
                                    </div>

                                </div>
                            

                            </div>  <br>

                        <button id="btnGuardar" @php if($intentos >=3) { echo " disabled ";}@endphp class="btn bg-megna waves-effect waves-light m-r-10" style="color:white"  >Enviar </button>

                        @endif

                        @if($this->data["actividad_punteo"]!==0)
                        <button class="btn bg-megna waves-effect waves-light m-r-10" style="color:white"  onclick="history.go(-1)">Regresar </button>

                        @endif
                            
                            @php if($this->data["intentos"] >=3) { echo "<label for='exampleInputuname' style='color:#d0d31e'>Solamente puedes subir un archivo hasta tres veces, comuniquese con su instructor</label>";}@endphp
                            
                                       
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    
                    </form>
            </div>
            </div>        
        </div>
    </div>
@includeIf('blades/_js')
@endsection