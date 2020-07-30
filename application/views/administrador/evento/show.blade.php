@extends('blades/index')

@section('title', ' Listado de Instructores')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="{{base_url()}}assets/components/plugins/tiny-editable/mindmup-editabletable.js"></script>
<script src="{{base_url()}}assets/components/plugins/tiny-editable/numeric-input-example.js"></script>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Intecap E-learning</h4>
        <h6 class="card-subtitle">Construir de Eventos <code>INTECAP | TICS</code></h6>
        <div class="table-responsive">
            <table class="table full-color-table full-inverse-table hover-table" id="table_principal">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>No. de evento</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de finalización</th>
                        <th>Fecha postergada</th>
                        <th>Horas</th>
                        <th>Instructor</th>
                        <th class="text-nowrap text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                    @if (strpos($item->no_evento,'_preview') === false)
                        <tr>
                            <th><a href="{{ base_url() }}curso/visualizar/{{ $item->curso_id }}">{{ model('curso')->get_by('id',$item->curso_id)->nombre }}</a></th>
                            <td>{{ $item->no_evento }}</td>
                            <td>{{ date('d-m-Y',strtotime($item->fecha_inicio)) }}</td>
                            <td>{{ date('d-m-Y',strtotime($item->fecha_final)) }}</td>
                            <td>{{ date('d-m-Y',strtotime($item->fecha_alargue)) }}</td>
                            <td>{{ $item->no_horas }}</td>

                            <td>{{ model('instructor')->get_by('id',$item->instructor_id)->nombre_instructor }} {{ model('instructor')->get_by('id',$item->instructor_id)->apellido_instructor }}</td>
                            <td class="text-nowrap text-center">
                                <a href="{{ base_url() }}evento/editar/{{$item->id}}"  data-toggle="tooltip" data-original-title="Modificar evento"> <i class="fas fa-edit text-warning m-r-10"></i> </a> | &nbsp;
                                <a href="#" class="modificarinstructor" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Modificar instructor"> <i class="fas fa-user text-warning m-r-10"></i> </a> | &nbsp;
                                <!--<a href="#" class="modificarestado" id="" data-toggle="tooltip" data-original-title="Cambiar estado"> <i class="fas fa-times text-danger m-r-10"></i> </a> | &nbsp;-->
                                <a href="#" class="eliminarevento" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Eliminar evento"> <i class="fas fa-trash text-danger m-r-10"></i> </a>
                                @if ($this->ion_auth->get_users_groups()->row()->id  == 5)
                                    | &nbsp;<a href="{{ base_url() }}curso/preview_evento/{{ $item->id }}" data-toggle="tooltip" data-original-title="Previsualizar Evento"> <i class="fas fa-eye text-success m-r-10"></i> </a>&nbsp;
                                @endif 
                            </td>

                        </tr>
                    @else
                        
                    @endif
                    
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var BASE_URL = "<?php echo base_url(); ?>";
        $('.modificarfecha').click(function(e) {
            var errores = {

                '-1': 'No se realizo la actualización de fecha',
                '-2': 'La fecha ingresada es incorrecta',
            };
            Swal.fire({
                title: 'Alargar fecha de cierre',
                html: '<input id="fecha" placeholder="Fecha" class="form-control mb-1" type="date">',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                showLoaderOnConfirm: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn bg-megna text-white',
                cancelButtonClass: 'btn btn-danger',
                preConfirm: function() {
                    return new Promise((resolve, reject) => {
                        resolve({
                            fecha: $('input[id="fecha"]').val()
                        });
                    });
                },
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    var data = {
                        fecha: $('input[id="fecha"]').val(),
                        id: e.currentTarget.id
                    };
                    $.ajax({
                        type: 'POST',
                        data: data,
                        url: BASE_URL + 'evento/modificarfecha',
                        dataType: 'html',
                        success: function(data) {
                            if (data > 0) {
                                location.reload();
                            } else {
                                errores.forEach(element => {
                                    console.log(element);

                                });
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: errores[data],
                                });
                            }
                        }
                    });

                }


            }).catch(swal.noop)
        });
        $('.eliminarevento').click(function(e) {
            Swal.fire({
                title: '¿Está seguro de realizar esta acción?',
                text: "¡No prodrá revertir esta acción!, Se le sugiere realizar una copia de seguridad",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#00897C",
                cancelButtonColor: "#DD6B55",
                background: '#263238',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Ingresar password',
                        html: '<div class="form-group text-left"><label for="exampleInputuname">Nombre de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="password" class="form-control" style="color:white;" id="password"  name="password" placeholder="Password"></div></div>',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: "#00897C",
                        cancelButtonColor: "#DD6B55",
                        background: '#263238',
                        preConfirm: function() {
                            return new Promise((resolve, reject) => {
                                resolve({
                                    password: $('input[placeholder="Password"]').val(),
                                });
                            });
                        },
                    }).then((resultado) => {
                        $.ajax({
                            type: 'POST',
                            data: {
                                'password': $('input[placeholder="Password"]').val()
                            },
                            url: BASE_URL + 'evento/confirmarEliminar',
                            dataType: 'html',
                            success: function(data) {
                                if (data == 1) {
                                    $.ajax({
                                        type: 'POST',
                                        data: {
                                            'id': e.currentTarget.id
                                        },
                                        url: BASE_URL + 'evento/eliminarevento',
                                        dataType: 'html',
                                        success: function(data) {
                                            if (data > 0) {
                                                Swal.fire(
                                                    'Eliminado!',
                                                    'El evento ha sido eliminado exitosamente',
                                                    'success'
                                                );
                                            } else {
                                                Swal.fire({
                                                    type: 'error',
                                                    title: 'Oops...',
                                                    text: 'No se logró realizar esta opción',
                                                });
                                            }
                                        }
                                    });

                                } else {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: 'No se logró realizar esta opción',
                                    });
                                }
                            }
                        });

                    });


                }
            })
        });
        $('.modificarinstructor').click(function(e) {
            var datos = null;
            $.ajax({
                type: 'POST',
                url: BASE_URL + 'evento/getinstructor',
                dataType: 'html',
                success: function(data) {
                    var session = $.parseJSON(data);
                    var options = {};
                    $.map(session,
                        function(o) {
                            options[o.id] = o.nombre_instructor + ' ' + o.apellido_instructor;
                        });
                    Swal.fire({
                        title: '<h2>Asignar instructor</h2>',
                        text: 'Asigna un instructor diferente al evento',
                        input: 'select',
                        inputOptions: options,
                        showCancelButton: true,
                        confirmButtonText: 'Agregar',
                        cancelButtonText: 'Cancelar',
                        inputPlaceholder: 'Seleccionar',
                        confirmButtonColor: "#00897C",
                        cancelButtonColor: "#DD6B55",
                        background: '#263238',
                    }).then(function(inputValue) {
                        //console.log(inputValue);
                        if (inputValue) {
                            $.ajax({
                                type: 'post',
                                data: {
                                    'evento_id': e.currentTarget.id,
                                    'instructor_id': inputValue['value']
                                },
                                url: BASE_URL + 'evento/modificareventoinstructor',
                                dataType: 'html',
                                success: function(valor) {
                                    if (valor > 0) {
                                        location.reload();
                                    }
                                }
                            })
                            //console.log(inputValue);

                        }
                    });


                }
            });
            //console.log(datos);

        });
    });
</script>

@endsection