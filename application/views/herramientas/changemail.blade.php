@extends('blades/index_examen')

@section('title', ' Agregar curso')

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


if($flag == 1){
    $datos = model('user')->get_by('carnet', $carnet);
        if($datos){
            if(count($datos) > 0){

                $nombres = $datos->first_name;
                $apellidos = $datos->last_name;
                $carnet = $datos->carnet;
                $email = $datos->username;
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
                        <center class=""><h1> Se ha realizado el cambio del correo electronico del participante exitosamente.<p>
                            <br>
                            
                            
                            <h4 class=""> <td> <input type="button" class ="btn btn-success" onclick="location.href='https://e-learning.intecap.tech';" value="ir a Inicio" /></td> </h4></tr>
                       
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