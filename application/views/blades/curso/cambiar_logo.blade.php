@extends('blades/index_examen')

@section('title', ' Agregar curso')

@section('content')

@php
    $curso_id = $this->data["curso_id"];
   
    $sql = "SELECT * FROM cursos WHERE id = $curso_id;";
    $result = $this->db->query($sql);
 
    if($result->num_rows() > 0 ){
        $fila = $result->row();
          $logo = base_url() . $fila->logo;

    }

    
@endphp


<div class="row">
    <div class="col-lg-1 col-xlg-1 col-md-1"></div>
        <div class="col-lg-9 col-xlg-9 col-md-9">
                <div class="card">
                    <div class="card-body">
                        <form  method="POST" enctype="multipart/form-data" action="../subir_logo" >
                        <center class=""> <img src="{{$logo}}" />
                        <br><br><br><input type="hidden" id="curso_id" name="curso_id" value='{{$curso_id}}'><br>
                            <table class = "table table-dark table-striped" width = "80%">
                            <h4 class=""> <td>Nuevo Logo del curso:</td> <td><div class="custom-file">

                            <input type="file" class="custom-file-input" id="archivo" name="archivo" accept="image/x-png,image/gif,image/jpeg" value="">
                                <label class="custom-file-label form-control" for="imagen" aria-describedby="imagen">Seleccione un archivo</label>
                              </div></td></h4></tr>
                            <h4 class=""> <td><input type="submit"  class = "btn btn-success" value="Modificar"> 
                                <input type="button" class ="btn btn-success" onclick="location.href='https://e-learning.intecap.tech';" value="Cancelar" /></td> 
                                <td>La imagen debe ser de  270px X 90px </h4></tr>
                            <div class="ml-auto">
                            
                                    
                            </div>
                            <br/>        
                            </table>
                   
                        </center> 
                    </form>
                    </div>
                    
                    
                    
                    
                </div>
            </div>    
 
    
</div>
    
    
     

        



@includeIf('blades/_js')


@endsection