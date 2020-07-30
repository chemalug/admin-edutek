@extends('blades/index_nada')

@section('title', 'Listado Notas')

@section('content')




<div class="row">
    <div class="col-lg-2 col-xlg-2 col-md-2"></div>
        <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="" method = "POST">
                        <center class=""><h1> Listado Notas</h1><p><h2>
                            <script>
                                document.write('<a href="' + document.referrer + '"><< Regresar</a>');
                              </script></h2>
                            <br>
                            <table class = "table table-dark table-striped" width = "90%">
                                <tr><th>N.</th><th>Carnet</th><th>Nombres</th><th>Apellidos</th><th>Nota acumulada</th><th>Último ingreso</th></tr>
                             
                            @php
                               
                                $contador = 1;
                               foreach($alumnos_lista as $alumno1){

                                echo "<tr><th>";      
                                echo $contador;
                                echo "</th><th>";
                                echo $alumno1->carnet;
                                echo "</th><th>";
                                echo $alumno1->nombres;
                                echo "</th><th>";
                                echo $alumno1->apellidos;
                                
                                    $nota = 0;
                                    
                                        foreach($alumnos_con_nota as $alumno2){
                        
                                            if($alumno1->carnet==$alumno2->carnet)
                                          $nota = $alumno2->nota;
                        
                                        }
                                
                                echo "</th><th>";
                                echo $nota;
                                echo "</th><th>";
                                echo date('m/d/Y H:i:s', $alumno1->last_login);                              
                                echo"</th></tr>";


                                
                                    $contador++;
                        
                                }
                                
                            @endphp 
                            
                            </table>
                   
                        </center> 
                    </form>

                    </div>
                    
                    
                    
                    
                </div>
            </div>    
 
    
</div>
    
    
     

        



@includeIf('blades/_js')


@endsection