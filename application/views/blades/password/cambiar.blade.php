@extends('blades/index_examen')

@section('title', ' Agregar curso')

@section('content')

@php

@endphp


<div class="row">
    <div class="col-lg-2 col-xlg-2 col-md-2"></div>
        <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form  method="POST" enctype="multipart/form-data" action="restablecer_password" >
                        <center class=""> 
                            <br><br><br><br>
                            <table class = "table table-dark table-striped" width = "80%">
                            <h1 class=""> <td>Recuperación de contraseña</td></h1></tr>
                            <h4 class=""> <td>Ingrese su Correo electronico:</td> <td><input type="text" class="form-control" value="" name="telefono"></td></h4></tr>
                            
                            
                            <h4 class=""> <td><input type="submit"  class = "btn btn-success" value="modificar"></td> <td>La imagen debe ser .gif, .jpg o .png, ademas de ser  cuadrada y no mayor a 3 megas.<br/>Solamente puede cambiar su telefono y foto de perfil<br/> Si tiene error en el nombre o correo comunicarse con su instructor.</td></h4></tr>
                            <div class="ml-auto">
                                <a href="javascript:void(0)" class="link m-r-10 " data-toggle="tooltip" title="La imagen debe ser .gif, .jpg o .png, ademas de ser cuadrada y no mayor a 3 megas.
                                Solamente puede cambiar su telefono y foto de perfil
                                Si tiene error en el nombre o correo comunicarse con su instructor."><i
                                        class="mdi mdi-heart-outline"></i></a> <a href="javascript:void(0)"
                                    class="link" data-toggle="tooltip" title="Share"><i class="mdi mdi-share-variant"></i></a>
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