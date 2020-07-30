@extends('blades/index')

@section('title', ' Listado de Instructores')

@section('content')
<div class="card">
    <div class="card-body">
        <h2 class="card-title text-megna">Intecap E-learning</h2>
        <h4 class="card-title">Listado de Instructores INTECAP | TICS</h4>
        <div class="table-responsive">
            <table class="table full-color-table full-inverse-table hover-table" id="table_principal">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th class="text-nowrap">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                    <tr>
                        <td>{{ $item->nombre_instructor}}</td>
                        <td>{{ $item->apellido_instructor }}</td>
                        <td>{{ $item->email_instructor }}</td>
                        <td class="text-nowrap">
                            <a href="{{ base_url() }}instructor/edit/{{ $item->id }}" data-toggle="tooltip" data-original-title="Editar instructor" style="font-size:20px;"> <i class="mdi mdi-account-edit text-megna"></i></a> |
                            <a href="#" class="resetpassword" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Reset password"><i class="fas fa-sync-alt"></i></a> |
                            <a href="#" class="reenviarpassword" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Reenviar email"><i class="fas fa-reply-all text-warning"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    var BASE_URL = "<?php echo base_url(); ?>";
    $(document).ready(function() {
        $('.resetpassword').click(function(e) {
            Swal.fire({
                title: '¿Restablecer password?',
                text: "Se establece el password al valor por defecto: 12345678",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, restablecer!',
                confirmButtonClass: 'btn bg-megna text-white',
                cancelButtonClass: 'btn btn-inverse',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'instructor/reset',
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
                                //location.reload();
                            } else {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: '¡Algo salió mal!, verifica que los datos esten ingresados',
                                    type: 'error'
                                });
                            }
                        }
                    });

                }
            })
        });
        $('.reenviarpassword').click(function(e) {
            Swal.fire({
                title: 'Reenviar password',
                text: "¿Deseas envíar el password de la cuenta por email?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: '¡Sí, evníar!',
                confirmButtonClass: 'btn bg-megna text-white',
                cancelButtonClass: 'btn btn-inverse',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: BASE_URL + 'instructor/reenviar',
                        data: {
                            'id': e.currentTarget.id
                        },
                        dataType: 'html',
                        success: function(data) {
                            if (data == 1) {
                                Swal.fire({
                                    title: '¡Proceso completado!',
                                    text: 'Se ha completado el registro y se envío un correo con usuario y password para el ingreso a la plataforma',
                                    type: 'success'
                                });
                                //location.reload();
                            } else {
                                Swal.fire({
                                    title: 'Oops...',
                                    text: '¡Algo salió mal!, verifica que los datos esten ingresados',
                                    type: 'error'
                                });
                            }
                        }
                    });

                }
            })
        });
    });
</script>
@endsection