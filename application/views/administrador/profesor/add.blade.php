@extends('blades/index')

@section('title', ' Agregar Profesor')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Agregar Profesor</h2>
                <h4 class="card-title text-center"><code>Edutek E-learning</code></h4>
                <form>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                          <label for="validationDefault01">Nombres</label>
                          <input type="text" class="form-control"  name="nombres" id="nombres" placeholder="Nombres" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="validationDefault02">Apellidos</label>
                          <input type="text" class="form-control"  name="apellidos" id="apellidos" placeholder="Apellidos" required="">
                        </div>
                        <div class="col-md-4 mb-3">
                          <label for="validationDefaultUsername">Username</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="inputGroupPrepend2">@</span>
                            </div>
                            <input type="email" class="form-control"  name="email" id="email" placeholder="example@Edutek.edu.gt" aria-describedby="inputGroupPrepend2" required="">
                          </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                          <label for="validationDefault03">Dirección</label>
                          <input type="text" class="form-control"  name="direccion" id="direccion" placeholder="Dirección" required="">
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationDefault04">Telefono</label>
                          <input type="number" class="form-control" id="telefono" name="telefono" placeholder="telefono" required="">
                        </div>
                        <div class="col-md-3 mb-3">
                          <label for="validationDefault05">DPI</label>
                          <input type="number" class="form-control" id="dpi" name="dpi" placeholder="DPI" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                          <label class="form-check-label" for="invalidCheck2">
                            Se estará enviando al email ingresado los accesos a la plataforma
                          </label>
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect waves-light m-r-10" type="submit">Guardar</button>
                    <a href="{{ base_url()}}profesor/show" class="btn btn-danger waves-effect waves-yellow" type="button">Cancelar</a>
                </form>
            </div>
        </div>        
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    //var BASE_URL = "<?php echo base_url();?>"
    var BASE_URL = '{{ base_url() }}'
    $(document).ready(function() {
        $('#btnGuardar').click(function() {
            var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!$('#email').val().match(mailformat)){
                alert('El email ingresado no es válido');
            } else {
                Swal.fire({
                title: 'Profesor',
                text: '¿Estás seguro de realizar esta acción?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, agregar!',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-inverse',
                cancelButtonText: 'Cancelar',
                buttonsStyling: false,
                }).then((result) => {
                    var nombre = $('#nombre').val();
                    var codigo = $('#codigo').val();
                    var email  = $('#email').val();
                    var data = {
                        'nombre' : nombre,
                        'codigo' : codigo,
                        'email'  : email
                    };
                    
                if (result.value) {
                    $.ajax({
                        type:       'POST',
                        url:        BASE_URL+'Profesor/addaction',
                        data:       data,
                        dataType:   'html',
                        success:    function(data) {
                            if (data != 0) {
                                Swal.fire({
                                    title:  'Agregado!',
                                    text:   'Se ha agregado el registro y se envío un correo con usuario y password para el ingreso a la plataform',
                                    type:   'success'
                                });
                            } else {
                                Swal.fire({
                                    title:  'Oops...',
                                    text:   '¡Algo salió mal!, verifica que los datos esten ingresados',
                                    type:   'error'
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