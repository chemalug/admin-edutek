@extends('blades/index_examen')

@section('title', ' Agregar curso')

@section('content')

@php
    $datos = $this->data["datos"];
    $identidad = $this->data["user"];
    $correo = $identidad;
    $nombres = $this->data["datos"]->first_name;
    $apellidos = $this->data["datos"]->last_name;
    $email = $this->data["datos"]->email;
    $profile_image = $this->data["datos"]->profile_image;
    $telefono = $this->data["datos"]->telefono;
    $carnet = $this->data["datos"]->carnet;

    





@endphp


<div class="row">
    <div class="col-lg-2 col-xlg-2 col-md-2"></div>
        <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form  method="POST" enctype="multipart/form-data" action="subir_foto_perfil" >
                        <center class=""> <img src="../{{$profile_image}}" class="img-circle" width="150"  height="150"/>
                            <br><br><br><br>
                            <table class = "table table-dark table-striped" width = "90%">
                            <h4 class=""> <tr><td width="35%">Carnet:</td><td>{{$carnet}}</td></tr></h4>
                            <h4 class=""> <tr><td width="30%">Nombres:</td><td>{{$nombres}}</td></tr><tr><td>Apellidos</td><td> {{$apellidos}}</td></tr> </h4>
                            <h4 class=""> <td>Correo electronico:</td> <td>{{$email}}</td></h4></tr>
                            <h4 class=""> <td>Teléfono:</td> <td><input type="text" class="form-control" value="{{$telefono}}" name="telefono" style="color:white"></td></h4></tr>
                            <h4 class=""> <td>Nueva imagen de perfil: <a href="javascript:void(0)" class="mdi mdi-help-circle" data-toggle="tooltip" title="La imagen debe ser .gif, .jpg o .png, ademas de ser cuadrada y no mayor a 3 megas.
                                Solamente puede cambiar su telefono y foto de perfil
                                Si tiene error en el nombre o correo comunicarse con su instructor."></a></td> <td><div class="custom-file">
                            <input type="file" class="custom-file-input" id="archivo" name="archivo" accept="image/x-png,image/gif,image/jpeg" value="">
                                <label class="custom-file-label form-control" for="imagen" aria-describedby="imagen">Seleccione un archivo</label>
                              </div></td></h4></tr>
                            <h4 class=""> <td><input type="submit"  class = "btn btn-success" value="Actualizar cambios"> <input type="button" class ="btn btn-success" onclick="location.href='https://elearning.edutek.org';" value="Finalizar la edición" /></td> <td></td></h4></tr>
                            <div class="ml-auto"><td></td>
                                 
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