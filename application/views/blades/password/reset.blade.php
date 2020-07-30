@extends('blades/password/index_password')

@section('title', ' Agregar curso')

@section('content')

@php

@endphp


<div class="row">
    <div class="col-lg-2 col-xlg-2 col-md-2"></div>
        <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form  method="POST" enctype="multipart/form-data" action="../reset_password" >
                        <center class=""> 
                            <br><br><br><br>
                             <h1 class=""> Recuperacion de Contraseña</h1>
                             <h4 class=""> Ingrese su correo, se generará una nueva contraseña la cual se enviará a la dirección de correo que usted registró en el Centro de Tics.</h4>
                            <table class = "table table-dark table-striped" width = "80%">

                           
                           <tr> <h4 class=""> <td>Correo electronico:</td> <td><input type="text" class="form-control" value="" name="email"></td></h4></tr>
                            
                            
                            <h4 class=""> <td><input type="submit"  class = "btn btn-success" value="Restablecer"></td> <td></td></h4></tr>
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