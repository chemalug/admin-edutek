@extends('blades/index')

@section('title', ' Editar Instructor')

@section('content')
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="card text-white">
            <div class="card-body">
                <h2 class="card-title text-center text-megna">Editar Instructor</h2>
                <h4 class="card-title text-center">Intecap E-learning</h4>


                <div class="form-group">
                    <input type="text" hidden name="id" id="id" value="{{ $datos->id }}">
                    <label for="exampleInputuname">Nombres del instructor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ti-agenda"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" style="color:white;" name="nombre" id="nombre" placeholder="Nombres" value="{{ $datos->nombre_instructor }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputuname">Apellidos del instructor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ti-agenda"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" style="color:white;" name="codigo" id="codigo" placeholder="Apellidos" value="{{ $datos->apellido_instructor }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputuname">Email del instructor</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="ti-email"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control" style="color:white;" name="email" id="email" placeholder="example@intecap.edu.gt" value="{{ $datos->email_instructor }}">
                    </div>
                </div>
                <button id="btnGuardar" class="btn bg-megna waves-effect waves-light m-r-10" style="color:white">Guardar</button>
                <button class="btn btn-inverse waves-effect waves-light">Cancelar</button>


            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    //var BASE_URL = "<?php echo base_url(); ?>"
    var BASE_URL = '{{ base_url() }}'
    $(document).ready(function() {
        $('#btnGuardar').click(function() {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!$('#email').val().match(mailformat)) {
                alert('El email ingresado no es válido');
            } else {
                Swal.fire({
                    title: 'Instructor',
                    text: '¿Estás seguro de realizar esta acción?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, modificar!',
                    confirmButtonClass: 'btn bg-megna text-white',
                    cancelButtonClass: 'btn btn-inverse',
                    cancelButtonText: 'Cancelar',
                    buttonsStyling: false,
                }).then((result) => {
                    var id      = $('#id').val();
                    var nombre = $('#nombre').val();
                    var codigo = $('#codigo').val();
                    var email = $('#email').val();
                    var data = {
                        'nombre': nombre,
                        'codigo': codigo,
                        'email': email,
                        'id'    : id
                    };

                    if (result.value) {
                        $.ajax({
                            type: 'POST',
                            url: BASE_URL + 'instructor/editaction',
                            data: data,
                            dataType: 'html',
                            success: function(data) {
                                if (data != 0) {
                                    Swal.fire({
                                        title: 'Agregado!',
                                        text: 'Se ha agregado el registro y se envío un correo con usuario y password para el ingreso a la plataform',
                                        type: 'success'
                                    });
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
                });
            }

        });
    });
</script>
@endsection