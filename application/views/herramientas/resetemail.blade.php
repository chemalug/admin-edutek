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
                        <form action="{{base_url()}}herramientas/updatemail/" method = "POST">
                        <center class=""><h1>Modificación de Correo Electrónico</h1><p><p>
                            
                            <table class = "table table-dark table-striped" width = "80%">
          
                                    <tr><td width= "20%">carnet</td><td width= "60%"><input type="text" readonly name="carnet" id="carnet" value="{{$carnet}}" ></td><td width= "20%"></td></tr>
                                    <tr><td>nombres</td><td>{{$nombres}}</td><td></td></tr>
                                    <tr><td>apellidos</td><td>{{$apellidos}}</td><td></td></tr>
                            <tr><td>Antiguo email</td><td><input style= "width:100%;background-color:gray;" type="text" value = "{{$email}}" readonly name="old_email" id="old_email"></td><td></td></tr>
                            <tr><td>Nuevo email</td><td><input style= "width:100%" type="text" value = "{{$email}}" name="new_email" id="new_email"> </td><td></td></tr>

                                    

                            <h4 class=""> <td> <input type="submit" style= "width:100%"  class ="btn btn-success" value="Cambiar correo" /> </td> </h4></tr>
                       
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