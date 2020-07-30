@extends('blades/index_examen')

@section('title', ' Agregar curso')

@section('content')



@section('title', ' Principal')





<div class="row">


    <div class="col-12 mt-12" style="text-align: center">
            
        <div id="code1" class="collapse highlight">
        </div>
        <br>
        <div class="card">
            <div class="card-header" style="color:white">
                <h3>Herramientas del evento</h3>
                </div>
        </div>
    </div>    
</div>


    <div class="row">
            
    <div class="col-12 mt-12" style="text-align:center">
        
        <div id="code1" class="collapse highlight">
        </div>
        <div class="card">
            <div class="card-header" style="color:white">
                    <h3>{{$nombrecurso}}</h3>
                    <h3>{{$datos_evento->no_evento}}</h3>
                    <div class="table-responsive">
                            <table class="table no-wrap" style="color:white , text-align:center">
                                <thead>
                                    <tr>
                                        <th width="45px">ID</th>
                                        <th>Carnet</th>
                                        <th>Participante</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="table-active" style="">
                                        <td >1</td>
                                        <td><input type="text"> </td>
                                        <td><input type="text"> </td>
                                        <td><input type="text"> </td>
                                        
                                    </tr>
                                    <tr class="table-active">
                                            <td scope="row">1</td>
                                            <td>Column content</td>
                                            <td>Column content</td>
                                            <td>Column content</td>
                                        </tr>
                                     
                                 
                                </tbody>
                            </table>
                        </div>
                    
            </div>
            <div class="card-body">  
                <a href="#" class="btn btn-primary" style="width:200px">Reenvio de diploma</a>
                <a href="#" class="btn btn-primary" style="width:300px">Reiniciar intentos de examen</a>
                <a href="#" class="btn btn-primary" style="width:200px">Registro de actividades</a>
                <a href="{{base_url()}}herramientas/participantes" class="btn btn-primary" style="width:200px">Desasignar</a>
                <a href="#" class="btn btn-primary" style="width:200px">Modificar datos</a>
                <a href="#" class="btn btn-primary" style="width:200px">registro de actividades</a>
                <a href="#" class="btn btn-primary" style="width:200px">Re asignar Contraseña
                    </a>
            </div>
        </div>
    </div>

    



                    </div>
                 
            

        



@includeIf('blades/_js')


@endsection