@extends('blades/index_nada')

@section('title', 'Restaurar Password')

@section('content')

@php
$carnet =  $this->input->post('carnet');
                $nombres = "No hay ningun alumno con ese número de carnet";
                $apellidos = "";
                $email = "";

if($carnet == "" or $carnet == null){
$flag = 0;
$carnet = "";

} else {
    $flag = 1;

}

$enable = "disable";
if($flag == 1){
    $datos = model('user')->get_by('carnet', $carnet);
        if($datos){
            if(count($datos) > 0){

                $nombres = $datos->first_name;
                $apellidos = $datos->last_name;
                $carnet = $datos->carnet;
                $email = $datos->username;
                $enable = "";
            }
             
             
        }


}



@endphp


<div class="row">
    <div class="col-lg-2 col-xlg-2 col-md-2"></div>
        <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="" method = "POST">
                        <center class=""><h1> Herramientas</h1><p>En el presente apartado puede realizar las acciones de restaurar contraseña, modificar correo y nombre y apellido del participante.<p>
                            <br>
                            <table class = "table table-dark table-striped" width = "80%">
                            <h4 class=""> <tr><td width="30%">Consultar por carnet:</td><td><input type="text" name="carnet" id = "carnet"></td><td><button  class = "btn btn-success" style= "width:100%" >Consultar </button></td></tr></h4>
                            @if ($flag == 1)
                                    <tr><td width= "20%">Carnet</td><td width= "60%">{{$carnet}}</td><td width= "20%"><input type="button" style= "width:100%"  class ="btn btn-success" onclick="location.href='{{base_url()}}herramientas/rp/{{$email}}';" $enable value="Restablecer password"  /></td></tr>
                                    <tr><td>Nombres</td><td>{{$nombres}}</td><td><input type="button" style= "width:100%"  class ="btn btn-success" onclick="location.href='{{base_url()}}herramientas/changename/{{$carnet}}';"  value = "Modificar nombres y apellidos"   /></td></tr>
                                    <tr><td>Apellidos</td><td>{{$apellidos}}</td><td></td></tr>
                            <tr><td>email</td><td><input style= "width:100%; background-color:gray;" type="text" value = "{{$email}}" readonly> </text></td><td><input type="button" style= "width:100%"  class ="btn btn-success" onclick="location.href='{{base_url()}}herramientas/changemail/{{$carnet}}';"  value = "Modificar email"   /></td></tr>
                                    

                            @endif
                            <h4 class=""> <td> <input type="submit" class ="btn btn-success"  value="ir a Inicio" /></td> </h4></tr>
                       
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