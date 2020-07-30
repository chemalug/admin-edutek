
@extends('blades/index_inscribir')

@section('title', 'Inscribir')

@section('content')
<div class="row page-titles">

</div>

<div class="row">
    
        <div class="col-lg-8 col-md-8">
            <div class="card">
                <div class="card-body" style="height:800px;">   
                    <form action="" method="post">
                       <center> <h2>Formulario de inscripción</h2></center><br>
                        <table>
                        <tr><td>Nombres</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>Apellidos</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>DPI O CUI</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>Departamento de nacimiento</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>Municipio de nacimiento</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>Fecha de nacimiento</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>Ultimo grado aprobado</td><td><input type="text" id="fname" name="fname" placeholder="(p.e. 4to perito contador o 5 semestre ingenieria electronica)"></td></tr>
                        
                        <tr><td>telefono casa </td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>telefono celular</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>correo electronico</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>zona donde reside </td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>Direccion</td><td><input type="text" id="fname" name="fname"></td></tr>
                        <tr><td>Empresa (si labora)</td><td><input type="text" id="fname" name="fname"></tr></td>
                        </table>
                        <br>
                        <input type="submit" value = "Inscbirme" class ="btn btn-success">
                    
                </div>
                    
                
                
            </div>
        </div>
    
</div>
@includeIf('blades/_js')
@endsection