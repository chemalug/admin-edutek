@extends('blades/index_nada')

@section('title', 'Restaurar Password')

@section('content')

@php
echo $carnet;
$enable = "disable";

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






@endphp


<div class="row">
    <div class="col-lg-2 col-xlg-2 col-md-2"></div>
        <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{base_url()}}herramientas/updatename/" method = "POST">
                        <center class=""><h1>Modificación de Correo Electrónico</h1><p><p>
                            
                            <table class = "table table-dark table-striped" width = "80%">
          
                                    <tr><td width= "20%">carnet</td><td width= "60%"><input type="text" style= "width:100%;background:gray;" readonly name="carnet" id="carnet" value="{{$carnet}}" ></td><td width= "20%"></td></tr>
                                    <tr><td>nombres</td><td><input style= "width:100%" type="text" value = "{{$nombres}}" name="nombres" id="nombres"> </td><td></td></tr>
                                    <tr><td>apellidos</td><td><input style= "width:100%;" type="text" value = "{{$apellidos}}" name="apellidos" id="apellidos"> </td><td></td></tr>
                            <tr><td>email</td><td><input style= "width:100%;background:gray;" type="text" value = "{{$email}}" readonly name="old_email" id="old_email"></td><td></td></tr>

                                    

                            <h4 class=""> <td> <input type="submit" style= "width:100%"  class ="btn btn-success" value="Modificar Nombres" /> </td> </h4></tr>
                       
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