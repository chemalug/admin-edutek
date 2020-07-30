@extends('blades/index_i')

@section('title', ' Principal instructor')

@section('content')


<div class="row page-titles">

</div>
<div class="row">
    <div class="col-lg-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title text-center">
                    <h2>{{ model('curso')->get_by('id',$this->session->userdata['curso_id'])->nombre }}</h2>
                    <h3>Listado de participantes</h3>
                </div>
                <ul class="nav nav-tabs customtab">
                    <li class=" nav-item"> <a href="#navpills2-1" class="nav-link active" data-toggle="tab" aria-expanded="false">Participantes</a> </li>
                </ul>
                <div class="tab-content">
                    <div id="navpills2-1" class="tab-pane active" role="tablist">
                        <div style="height:30px;"></div>
                        <div class="row card-subtitle">
                            <div class="col-md-3">
                                @php
                                $id_curso = $this->session->userdata('curso_id');
                                $sql = "SELECT * FROM cursos WHERE id = $id_curso";
                                $resultado = $this->db->query($sql);
                                $logo = "";
                                if($resultado->num_rows() > 0){
                                $fila = $resultado->row();
                                $logo = base_url() . $fila->logo;
                                }
                                @endphp
                                <img src="{{$logo}}" height="64">
                            </div>
                            <div class="col-md-9 text-right">
                            <a href="{{ base_url() }}evento/dosificacion/{{ $evento_id }}" class="btn btn-success waves-effect waves-light m-r-10" style="color:white;width:195px;">Subir Dosificación<i class="mdi mdi-grease-pencil"></i> </a>
                            
                                <button id="{{ $evento_id }}" class="btn btn-success bg-megna dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Participantes <i class="mdi mdi-account-plus"></i> </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item btnAgregarEstudiante" href="#">Agregar participante</a>
                                    <a class="dropdown-item btnListadoNotas" href="#">Resumen de Notas</a>
                                    <a class="dropdown-item btnListadoConstancias" href="#">Códigos constancias</a>
                                    <a class="dropdown-item btnRestaurarContraseña" href="#">Herramientas</a>
                                  
                                    
                                </div>
                                <a href="{{ base_url() }}evento/evaluar/{{ $evento_id }}" class="btn btn-warning waves-effect waves-light m-r-10" style="color:white;width:120px;">Calificar<i class="mdi mdi-grease-pencil"></i> </a>
                                
                                <a href="{{ base_url() }}cerrar_evento/cerrar_evento/{{ $evento_id }}" class="btn btn-success  waves-effect waves-light m-r-10" style="color:white;width:195px;">Generar Diplomas <i class="mdi mdi-grease-pencil"></i> </a>
                                
                                   
                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="table-responsive">
                                    <table class="table full-color-table full-inverse-table hover-table" id="config-table">
                                        <thead>
                                            <tr role="row" style="background: #2F3D49">
                                                <th width='15%'>Carnet</th>
                                                <th width='30%'>Nombres</th>
                                                <th width= 30%'>Apellidos</th>
                                                <th width='35%'>Email</th>
                                             
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($eventousuario as $item)
                                            <tr>
                                                <th>{{ model('user')->get_by('id',$item->user_id)->carnet }}</th>
                                                <th>{{ model('user')->get_by('id',$item->user_id)->first_name }}</th>
                                                <th>{{ model('user')->get_by('id',$item->user_id)->last_name }}</th>
                                                <th>{{ model('user')->get_by('id',$item->user_id)->email }}</th>
                                                
                                               
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


</div>
@includeIf('blades/_js')
<!-- This is data table -->
<script src="{{ base_url() }}assets/components/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ base_url() }}assets/components/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>

</script>
<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";
    /**/
    $(document).ready(function() {
        $('input.city').on('input', function(e) {
            $.ajax({
                type: 'post',
                data: {
                    carnet: e.currentTarget.value
                },
                url: BASE_URL + 'evento/participante',
                dataType: 'html',
                success: function(data) {
                    console.log(data);
                    //Escribimos las sugerencias que nos manda la consulta
                    $('#suggestions').fadeIn(1000).html(data);
                    //Al hacer click en alguna de las sugerencias
                    $('.suggest-element').on('click', function() {
                        //Obtenemos la id unica de la sugerencia pulsada
                        var id = $(this).attr('id');
                        //Editamos el valor del input con data de la sugerencia pulsada
                        $('input.city').val($('#' + id).attr('data'));
                        //Hacemos desaparecer el resto de sugerencias
                        $('#suggestions').fadeOut(1000);
                        alert('Has seleccionado el ' + id + ' ' + $('#' + id).attr('data'));
                        return false;
                    });
                }
            });

        });
        $('.cerrarevento').click(function(e) {
                Swal.fire({
                    title: '<h2 class="text-white">Cerrar evento</h2>',
                    text: 'Se cierra el evento y se notifica a los participantes la descarga de su constancia',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '¡Sí, proceder!',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: "#FFB33D",
                    cancelButtonColor: "#DD6B55",
                    background: '#263238',
                }).then((result) => {
                    if (result.value) {

                        Swal.fire({
                            title: 'Ingresar password',
                            html: '<div class="form-group text-left"><label for="exampleInputuname">Nombre de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="password" class="form-control" id="password"  name="password" placeholder="Password"></div></div>',
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
                                            url: BASE_URL + 'cerrar_evento/cerrar_evento',
                                            data: {
                                                'id': e.currentTarget.id
                                            },
                                            dataType: 'html',
                                            success: function(data) {
                                                if (data >= 1) {
                                                    Swal.fire({
                                                        title: '¡Proceso completado!',
                                                        text: 'Se ha completado el registro y se envío un correo con usuario y password para el ingreso a la plataforma',
                                                        type: 'success'
                                                    });
                                                    location.reload();
                                                } else {
                                                    Swal.fire({
                                                        title: 'Oops...',
                                                        text: '¡Algo salió mal!, verifica que los datos esten ingresados',
                                                        type: 'error'
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
        

    
        $('.btnAgregarEstudiante').click(function(e) {
            Swal.fire({
                title: 'Agregar participante',
                html: '<div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-id-badge"></i></span></div><input type="text" class="form-control carnet" style="color:white;" name="carnet" id="carnet" placeholder="Carnet"></div></div>' +
                    '<div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="mdi mdi-account"></i></span></div><input type="text" class="form-control" style="color:white;" name="nombres" id="nombres" placeholder="Nombres"></div></div>' +
                    '<div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="mdi mdi-account"></i></span></div><input type="text" class="form-control" style="color:white;" name="apellidos" id="apellidos" placeholder="Apellidos"></div></div>' +
                    '<div class="form-group"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-email"></i></span></div><input type="text" class="form-control" style="color:white;" name="email" id="email" placeholder="Email"></div></div>',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                showLoaderOnConfirm: true,
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55",
                background: '#263238',
                preConfirm: function() {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Carnet: $('input[placeholder="Carnet"]').val(),
                            Nombres: $('input[placeholder="Nombres"]').val(),
                            Apellidos: $('input[placeholder="Apellidos"]').val(),
                            Email: $('input[placeholder="Email"]').val(),
                        });
                    });
                },
                allowOutsideClick: false,
            }).then(function(result) {
                if (result.value) {
              
                    $.ajax({
                        type: 'POST',
                        data: {
                            'carnet': $('input[placeholder="Carnet"]').val(),
                            'nombres': $('input[placeholder="Nombres"]').val(),
                            'apellidos': $('input[placeholder="Apellidos"]').val(),
                            'email': $('input[placeholder="Email"]').val(),
                            'evento_id': e.currentTarget.id,
                        },
                        url: BASE_URL + 'evento/agregarParticipante',
                        dataType: 'html',
                        success: function(data) {
                            if (data == 0) {
                                Swal.fire({
                                    title: '¡Perfecto!',
                                    text: "Participante agregado correctamente",
                                    type: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok!'
                                }).then((result) => {
                                    if (result.value) {
                                        location.reload();
                                    } else {
                                        location.reload();
                                    }
                                });
                              
                            } else if (data == -1) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '¡Te faltó el carnet!',
                                });
                            } else if (data == -2) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '¡Te faltaron los nombres!',
                                });
                            } else if (data == -3) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '¡Te faltaron los apellidos!',
                                });
                            } else if (data == -4) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '¡Te faltó el email!',
                                });
                            } else if (data == -5) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '¡No se pudo enviar el email de confirmación!',
                                });
                            } else if (data == -6) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '¡El usuario que intentas agregar ya esta asignado a este evento!',
                                });
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: '¡Agrego al participante pero no pudo enviar el correo!',
                                });
                            }
                        }
                    });
                }
            });
        });
        
        $('.btnSubirArchivo').click(function(e) {
            var api = BASE_URL + 'evento/inscripcionArchivo';
            Swal.fire({
                title: "<h2>Subir archivo de inscripción</h2>",
                input: 'file',
                showCancelButton: true,
                confirmButtonText: 'Cargar',
                showLoaderOnConfirm: true,
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55",
                background: '#263238',
                inputAttributes: {
                    'accept': 'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                },
                onBeforeOpen: () => {
                    $(".swal2-file").change(function () {
                        var reader = new FileReader();
                        reader.readAsDataURL(this.files[0]);
                    });
                }
            }).then((file) => {
                if(file.value) {
                    var formData = new FormData();
                    var file = $('.swal2-file')[0].files[0];
                    formData.append("fileToUpload", file);
                    console.log('Entro');
                    $.ajax({
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        url: api,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (resp) {
                            Swal('Uploaded', 'Your file have been uploaded', 'success');
                        },
                        error: function() {
                            Swal({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                        }
                    })
                }
            });
            //sweet
        });


        
        $('.btnRestaurarContraseña').click(function(e) {
            var url = BASE_URL + 'herramientas/resetpassword'; 
            $(location).attr('href',url);


        });
            

        $('.btnListadoNotas').click(function(e) {
            var url = BASE_URL + 'herramientas/listado_notas/{{$evento_id}}'; 
            $(location).attr('href',url);


        });

        $('.btnListadoConstancias').click(function(e) {
            var url = BASE_URL + 'herramientas/listado_constancias/{{$evento_id}}'; 
            $(location).attr('href',url);


        });
            



        $(document).on('focusout', "#carnet", function(e) {



                $.ajax({
                    type: 'post',
                    data: {
                        carnet: e.currentTarget.value
                    },
                    url: BASE_URL + 'evento/participante',
                    dataType: 'html',
                    success: function(data) {
                        if (data != 0) {
                            var datos = JSON.parse(data);
                            $('input[id="nombres"]').val(datos['nombres']);
                            $('input[id="apellidos"]').val(datos['apellidos']);
                            $('input[id="email"]').val(datos['email']);
                            $('#nombres').attr('readonly', true);
                            $('#apellidos').attr('readonly', true);
                            $('#email').attr('readonly', true);
                        } else {
                            $('#nombres').attr('readonly', false);
                            $('#apellidos').attr('readonly', false);
                            $('#email').attr('readonly', false);
                            alert('No se encontró ningún participante asociado a ese carnet, favor de ingresar los datos del participante')
                            /*Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'No se encontró ningún participante asociado a ese carnet!',
                            })*/
                            $('input[id="nombres"]').val("");
                            $('input[id="apellidos"]').val("");
                            $('input[id="email"]').val("");
                        }



                    }
                });

            

        });
    });
 
</script>
<script>
    $('#config-table').DataTable({
        responsive: true,
        "aLengthMenu": [
            [20, 50, 75, -1],
            [20, 50, 75, "Todo"]
        ],
        "iDisplayLength": 20,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
    $('#config-table_1').DataTable({
        responsive: true,
        "aLengthMenu": [
            [20, 50, 75, -1],
            [20, 50, 75, "Todo"]
        ],
        "iDisplayLength": 20,
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
</script>
@endsection