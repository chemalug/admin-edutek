@extends('blades/index_nada')

@section('title', 'Listado Notas')

@section('content')




<div class="row">
    <div class="col-lg-2 col-xlg-2 col-md-2"></div>
        <div class="col-lg-8 col-xlg-8 col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="" method = "POST">
                        <center class=""><h1> Listado Diplomas</h1><p><h2>
                            <script>
                                document.write('<a href="' + document.referrer + '"><< Regresar</a>');
                              </script></h2>
                            <br>
                            <table class = "table table-dark table-striped" width = "90%">
                                <tr><th>N.</th><th>Nombres</th><th>Apellidos</th><th>Curso</th><th>Código Diploma</th><th>Validar diploma</th></tr>
                             
                            @php
                               
                                $contador = 1;
                               foreach($constancias as $constancia){
                                echo "<tr><th>";      
                                echo $contador;
                                echo "</th><th>";   
                                echo $constancia->nombres;
                                echo "</th><th>";
                                echo $constancia->apellidos;
                                echo "</th><th>";
                                echo $constancia->nombre_curso;
                                echo "</th><th>";
                                echo $constancia->token;
                                echo "</th><th>";
                               echo  '<a href="https://elearning.edutek.org/verificacion/verify/">validar</a>';
                                
                                    
                                   
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