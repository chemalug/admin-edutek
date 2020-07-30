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
                        <form action="/perfil/modificar">
                        <center class=""> <img src="../{{$profile_image}}" class="img-circle" width="150" height="150"/>
                            <br><br><br><br>
                            <table class = "table table-dark table-striped" width = "80%">
                            <h4 class=""> <tr><td width="30%">Carnet:</td><td>{{$carnet}}</td></tr></h4>
                            <h4 class=""> <tr><td width="30%">Nombres:</td><td>{{$nombres}}</td></tr><tr><td>Apellidos</td><td> {{$apellidos}}</td></tr> </h4>
                            <h4 class=""> <td>Correo electronico:</td> <td>{{$email}}</td></h4></tr>
                            <h4 class=""> <td>Telefono:</td> <td>{{$telefono}}</td></h4></tr>
                            <h4 class=""> <td><button  class = "btn btn-success">Modificar </button> <input type="button" class ="btn btn-success" onclick="location.href='https://elearning.edutek.org';" value="Finalizar la edición" /></td> <td>Puedes cambiar tu teléfono y foto de perfil, por error en el nombre o correo comunicarse con su instructor.</td></h4></tr>
                       
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