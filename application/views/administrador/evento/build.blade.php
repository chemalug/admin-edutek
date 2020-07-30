@extends('blades/index')

@section('title', ' Listado de Instructores')

@section('encabezado','Agregar contenido de Excel Intermedio')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center">Construir curso</div>
                        <div class="card-subtitle text-center"><code>Agregar contenido</code></div>
                        {{ form_open('evento/addtema')}}
                            <div class="form-group">
                                <label for="exampleInputuname">Tipo de contenido</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-layout-list-post"></i>
                                        </span>
                                    </div>
                                    <select name="es_actividad" id="es_actividad" class="form-control">
                                        <option value="" disabled selected hidden>Seleccionar opción</option>
                                        <option value="0" id="0" >Es actividad</option>
                                        <option value="1" id="1" >Es video</option>
                                        <option value="2" id="2" >Es examen</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputuname" class="text-left">Título del contenido</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-agenda"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="titulo" id="exampleInpututitulo" placeholder="Título">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputuname">Descripción del contenido</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-agenda"></i>
                                        </span>
                                    </div>
                                        <textarea class="form-control" rows="4" name="descripcion"  id="exampleInputudescripcion" placeholder="Descripción"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputuname">Link del video o recurso</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-vimeo"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="link" id="exampleInputlink" placeholder="https://www.ejemplo.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputuname">Punteo del contenido</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="ti-quote-right"></i>
                                        </span>
                                    </div>
                                    <input type="number" class="form-control" name="punteo" id="exampleInputpunteo" placeholder="0">
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <button class="btn bg-megna waves-effect waves-light m-r-10" style="color:white">Guardar</button>
                            </div>
                        
                        {{ form_close() }}
                    </div>
                </div>
            </div>

            <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>



            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                            <div class="col-md-8">
                                <h4 class="card-title">Listado de contenidos</h4>
                            </div>
                            <div class="col-md-4">
                                <h4 class="card-title"><code>Acciones</code></h4>
                            </div>
                        </div>
                        <div class="myadmin-dd dd" id="nestable">
                            <ol class="dd-list">
                                @php
                                    $contador = 0;
                                @endphp
                                @foreach ($list as $item)
                                        <li class="dd-item" data-id="{{ $item->id}}-{{ $item->orden }}">
                                        <div class="dd-handle">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <code>{{ $item->orden }}.</code>  {{ $item->titulo }} 
                                                </div>
                                                <div class="col-md-4">
                                                    <a href="#" class="agregarpregunta" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Agregar pregunta"><i class="fas fa-list text-success "></i></a> |
                                                    <a href="#" class="deleteContenido" id="{{ $item->id }}" data-toggle="tooltip" data-original-title="Eliminar contenido"><i class="fas fa-trash text-danger"></i></a> 

                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if (model('pregunta')->get_many_by('tema_id',$item->id))
                                            <ol class="dd-list">
                                                @foreach (model('pregunta')->get_many_by('tema_id',$item->id) as $value)
                                                    <li class="dd-item" data-id="{{ $value->id}}-{{ $value->tema_id }}">
                                                        <div class="dd-handle">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <code>{{ $value->pregunta }}.</code>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <a href="#" class="agregarrespuesta" id="{{ $value->id }}" data-toggle="tooltip" data-original-title="Agregar respuestas"><i class="fas fa-pencil-alt text-success "></i></a> |
                                                                    <a href="#" class="deletepregunta" id="{{ $value->id }}" data-toggle="tooltip" data-original-title="Eliminar pregunta"><i class="fas fa-trash text-danger"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (model('respuesta')->get_by('pregunta_id',$value->id)) 
                                                            <ol class="dd-list">
                                                                @php
                                                                    $cont = 0;
                                                                @endphp
                                                                @foreach (model('respuesta')->get_many_by('pregunta_id',$value->id) as $respuesta)
                                                                    <li class="dd-item" data-id="{{ $respuesta->id}}-{{ $respuesta->pregunta_id }}">
                                                                        <div class="dd-handle">
                                                                            <div class="row">
                                                                                <div class="col-md-8 text-muted">
                                                                                    {{ ++$cont }}. {{ $respuesta->respuesta }}.
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <a href="#" class="deleterespuesta" id="{{ $respuesta->id }}" data-toggle="tooltip" data-original-title="Eliminar respuesta"><i class="fas fa-trash text-danger"></i></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                            
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@includeIf('blades/_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script type="text/javascript">
    var BASE_URL = "<?php echo base_url();?>";
    $(document).ready(function() {
        $('.agregarpregunta').click(function(e) {
            Swal.fire({
                title: 'Escribe una pregunta',
                html: '<input id="pregunta" placeholder="Pregunta" class="form-control mb-1" type="text">',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                showLoaderOnConfirm: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Password"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{'pregunta':$('input[placeholder="Pregunta"]').val(),'tema_id':e.currentTarget.id},
                            url:BASE_URL+'tema/pregunta',
                            dataType: 'html',
                            success:function(data) {
                                if (data != 0) {
                                    location.reload();
                                } else {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: '¡Algo salió mal!',
                                    });
                                }
                                
                            }
                        });
                    }
                }).catch(swal.noop)
            });
        $('.agregarrespuesta').click(function(e) {
            Swal.fire({
                title: 'Agregar respuesta',
                html:   '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fas fa-pencil-alt"></i></span></div><input type="text" class="form-control" name="respuesta" id="respuesta" placeholder="Respuesta"></div> <br>' + 
                        '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fas fa-sort-numeric-up"></i></span></div><input type="number" class="form-control" name="punteo" id="punteo" placeholder="Punteo"></div> <br>' +
                        '<h6 class="card-subtitle">Si la respuesta es incorrecta,<code> el punteo correspondiente es 0</code></h6>',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                showLoaderOnConfirm: true,
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            respuesta:  $('input[placeholder="Respuesta"]').val(),
                            punteo:     $('input[placeholder="Punteo"]').val(),
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{
                                'respuesta':$('input[placeholder="Respuesta"]').val(),
                                'punteo':$('input[placeholder="Punteo"]').val(),
                                'pregunta_id': e.currentTarget.id},
                            url:BASE_URL+'tema/respuesta',
                            dataType: 'html',
                            success:function(data) {
                                if (data != 0) {
                                    location.reload();
                                } else {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: '¡Algo salió mal!',
                                    });
                                }
                                
                            }
                        });
                    }
                }).catch(swal.noop)
            });
        $('.deleteContenido').click(function(e) {
            Swal.fire({
                title: '¿Seguro quieres eliminar el contenido?',
                text: "¡No serás capaz de revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
                }).then((result) => {
                if (result.value) {
                    var path = BASE_URL+'tema/eliminar';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: {id:e.currentTarget.id},
                        dataType: 'html',
                        success: function(resultado) {
                            location.reload();
                            window.location.replace(BASE_URL+"evento/construir");
                        }
                    });
                    /**/
                }
            });
        });
        $('.deletepregunta').click(function(e) {
            Swal.fire({
                title: '¿Seguro quieres eliminar la pregunta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
                }).then((result) => {
                if (result.value) {
                    var path = BASE_URL+'tema/eliminarPregunta';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: {id:e.currentTarget.id},
                        dataType: 'html',
                        success: function(resultado) {
                            location.reload();
                            
                        }
                    });
                    /**/
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // Nestable
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                //output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
            } else {
                //console.log(output);
                output.val('JSON browser support required for this demo.');
            }
        };
        
        $('.dd').on('change', function() {
            var datos = [];
            $('.dd').nestable('serialize').forEach(element => {
                datos.push(element)
            });
            var valor = "";
            datos.forEach(function(element) {
                valor +=element.id + ";";
            });
            var valor = valor.substring(0, valor.length-1);
            var data = {
                data: valor
            };
            var BASE_URL = "<?php echo base_url();?>";
            $.ajax({
                type:   'post',
                url:    BASE_URL+'evento/ordenar',
                data:   data,
                success:function(response) {
                    location.reload();
                    
                }
            });
        });

        /*$('#btnGuardar').click(function() {
            
        });*/
        $(".dd a").on("mousedown", function(event) { // mousedown prevent nestable click
            event.preventDefault();
            return false;
        });

        $(".dd a").on("click", function(event) { // click event
            event.preventDefault();
            window.location = $(this).attr("href");
            return false;
        });
        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);
       // $('#nestable').nestable('collapseAll');

    });
	</script>
@endsection