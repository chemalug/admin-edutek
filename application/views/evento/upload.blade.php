@extends('blades/index_i')

@section('title', ' Dosificación del Curso')


@section('content')



<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                @php
                    $dosificacion = $evento_data->dosificacion;
                    if($dosificacion == ""  ){
                        $dosificacion = "No ha subido archivo hasta el momento";
                    }else { $dosificacion = site_url() . $dosificacion;

                    }

                @endphp


                        <div class="form-group">
                            <div class="card-body" style="background-color:#222526;text-align: center "> 
                            <label for="exampleInputuname" style="color:white" ><h2>DOSIFICACIÓN DEL CURSO  </h2></label><br/>
                            </div>
                            <div class="card-body">
                            </div>
                            <div class="card-body" style="background-color:#222526;">
                            <label for="exampleInputuname" style="color:white"><h3>Archivo actual de dosificación del curso:   </h3> </label><br/>
                            <label for="exampleInputuname" style="color:white"><h3> 
                                <a href="" target="_blank" onclick="window.open('{{$dosificacion}}','name','width=600,height=400')">Clic aquí para descargar la dosificación actual</a>
                            </h3> </label><br/>
                            <label for="exampleInputuname" style="color:white">  </label>
                            </div>
                            
                            

                            
                            <div class="card-body">
                                </div>
                            

                            

                                
                                <div class="card-body" style="background-color:#222526;">
                                        <label for="exampleInputuname" style="color:white"><h3>Subir / Actualizar:</h3></label><br/>
                                        <label for="exampleInputuname" style="color:white">En este apartado puedes subir o actualizar la dosificación del curso.</label><br/>
                                    <form name="form1" action="../subir_archivo/{{$id}}" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="tema_id" value="">
                                    <input type="hidden" name="es_actividad" value="">
                                  
                                  
                                  
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="archivo" name="archivo"  value="">
                                        <label class="custom-file-label form-control" for="imagen" aria-describedby="imagen">Seleccione un archivo</label>
                                    </div>

                                </div>
                            

                            </div>  <br>

                            <button id="btnGuardar" class="btn bg-megna waves-effect waves-light m-r-10" style="color:white"  >Enviar </button>
                            
                            
                            
                                       
                            
                            </div>
                        </div>
                        
                        
                        
                    
                    </form>
            </div>
            </div>        
        </div>
    </div>
@includeIf('blades/_js')
@endsection