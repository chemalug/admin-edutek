@extends('blades/index')

@section('title', ' Listado de cursos')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title">Plataforma E-learning</h2>
        <h4 class="card-title">Listado de cursos disponibles Edutek</h4>
        <div class="table-responsive">
            <table class="table full-color-table full-inverse-table hover-table" id="table_principal">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Descripción</th>
                        
                        <th class>Construir curso</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                    <tr>
                        <td>{{ $item->nombre}}</td>
                        <td>{{ $item->descripcion }}</td>
                        
                        <td class="text-nowrap"> &emsp;
                            <a href="{{ base_url() }}leccion/construir/{{ $item->id }}" data-toggle="tooltip" data-original-title="" > Construir <i class="fas fa-cubes text-megna m-r-10"></i> </a>
                        </td>
                        <td><a href="{{ base_url() }}curso/editar/{{ $item->id }}" class="" data-toggle="tooltip" data-original-title="Modificar Curs"> Editar <i class="fas fa-edit text-megna m-r-10"></i> </a> &nbsp;</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    var BASE_URL = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        $('.modificarcurso').click(function(e) {
            Swal.fire({
                title: '<h2>Modificar curso</h2> ',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Nombre del curso</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" id="titulo"  name="titulo" placeholder="Titulo" ></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Descripción del curso </label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" rows="4" id="descripcionL" name="descripcion" placeholder="Descripción"> </textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Duración de la lección</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" id="duracionL"  name="link" placeholder="Duración" ></div></div>',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55",
                background: '#263238',
                preConfirm: function() {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Texto"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then((result) => {

                });
        });
    });
</script>
@endsection