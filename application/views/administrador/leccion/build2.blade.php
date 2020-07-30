@extends('blades/index')

@section('title', ' Construir curso')

@section('encabezado','Agregar contenido')

@section('content')
 <style>
     .sidebar {
        height: 240px;
        min-height: 80px;
        overflow: auto;
        position: -webkit-sticky;
        position: sticky;
        top: 50%;
        overflow-y: hidden;
    }
 .main {
	 width: 60%;
	 height: 200vh;
	 min-height: 1000px;
	 display: flex;
	 flex-direction: column;
}
 .main, .sidebar {
	 
	 background-color: #263238;
	 border-radius: 10px;
	 color: #222;
	
}
 .wrapper {
	 #display: flex;
	 justify-content: space-between;
}
 body {
	
}
 code, pre {
	
}
 .bottom {
	 justify-self: bottom;
}
 
 </style>
    <div class="container-fluid text-white">
        <div class="wrapper">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">Construir curso</div>
                            <div class="card-subtitle text-center">  Agregar lecciones  </div>
                                <input type="text" value="{{ $curso_id }}" id="curso_id"  name="curso_id" hidden>
                                <div class="form-group">
                                    <label for="exampleInputuname">Nombre de la lección</label>
                                    <div class="input-group">
                                        
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <i class="ti-agenda"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" style="color:white;" id="titulo"  name="titulo" placeholder="Título">
                                    </div>
                                </div>
                                <div class="form-group">
                                        <label for="exampleInputuname">Duración Recomendada</label>
                                        <div class="input-group">
                                            
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="ti-agenda"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" style="color:white;" id="duracion"  name="duracion" placeholder="Duración">
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
                                            <textarea class="form-control" style="color:white;" rows="4" id="descripcion" name="descripcion"  placeholder="Descripción"></textarea>
                                    </div>
                                </div>
                                

                                <div class="text-center">
                                    <button id="btnGuardar" class="btn bg-megna waves-effect waves-light m-r-10 " style="color:white">Agregar <i class="fas fa-plus text-white"></i></button>
                                </div>
                            
                        </div>
                    </div>
                    <div class="sidebar">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title text-center " style="color:#e5e814;background-color=#eeee93;">  Pts. {{ $total_punteo}}</div>
                                @if (isset($mensaje))
                                    <div class=" text-center" style="color:white;font-size:15px;"> {{ $mensaje }} </div> 
                                @endif
                                <div class="text-center">
                                    <img src="{{ base_url()}}{{model('curso')->get_by('id',$curso_id)->logo}}" height="128">
                                    
                                </div>
                                <div class="text-center">
                                    <br>
                                    <a class="btn btn-warning" style="color:white;" href="{{ base_url() }}curso/cambiarimagen/{{$curso_id}}">Modificar logo del curso</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="myadmin-dd dd" id="nestable" >
                                <div class="row">
                                <div class="col-lg-5">
                                    <h4 class="card-title">Listado de contenidos</h4>
                                </div>
                                <div class="col-lg-7 text-center">
                                    <h4 class="card-title">  Acciones  </h4>
                                </div>
                            </div>
                                <ol class="dd-list">
                                    @foreach ($lecciones as $leccion)
                                        <li class="dd-item" data-id="a-{{ $leccion->id}}">
                                            <div class="dd-handle" style="background-color:#90908d;" >
                                                <div class="row" >
                                                    <div class="col-md-8" style="font-size:17px;color:white;">
                                                         {{  $leccion->orden }} .    {{ $leccion->titulo }} <br>Duración recomendada: {{ $leccion->duracion}} hrs
                                                         <br>Descripcion: <br/>{{ $leccion->descripcion }}
                                                    </div>
                                                    <div class="col-md-4 text-right">
                                                        <a href="#" class="agregaractividad" style="font-size:17px;color:white};" id="{{ $leccion->id }}" data-toggle="tooltip" data-original-title="Agregar Actividad" > <i class="fas fa-cogs" style="color:white;"></i></a> |
                                                        <a href="#" class="agregarvideo" style="font-size:17px;color:white;" id="{{ $leccion->id }}" data-toggle="tooltip" data-original-title="Agregar Video"> <i class="fas fa-video" style="color:white;"></i></a> |
                                                        <a href="#" class="agregarexamen" style="font-size:17px;color:white;" id="{{ $leccion->id }}" data-toggle="tooltip" data-original-title="Agregar Evaluación"> <i class="fas fa-th-list" style="color:white;"></i></a> |
                                                        <a href="#" class="modificarleccion" style="font-size:17px;color:white;" id="{{ $leccion->id }}" data-toggle="tooltip" data-original-title="Modificar Lección" data-key="{{ $leccion->titulo }}|{{ $leccion->descripcion }}|{{ $leccion->duracion }}" > <i class="fas fa-edit"></i></a> |
                                                        <a href="#" class="deleteLeccion " style="font-size:17px;color:#e3446b" id="{{ $leccion->id }}" data-toggle="tooltip" data-original-title="Eliminar Lección"> <i class="fas fa-trash"></i></a> 
                                                    </div>
                                                </div>
                                            </div>
                                            @if (model('tema')->get_by('leccion_id',$leccion->id ))
                                                <ol class="dd-list">
                                                    @foreach (model('tema')->order_by('orden','asc')->get_many_by('leccion_id',$leccion->id ) as $tema)
                                                        <li class="dd-item" data-id="b-{{ $tema->id }}-{{ $leccion->id }}">
                                                            <div class="dd-handle">
                                                                <div class="row">
                                                                    <div class="col-md-8 text-left" style="font-size:15px;color:white" >
                                                                        
                                                                        @if($tema->es_actividad == 1)
                                                                            <a href="{{ $tema->link }}"> {{ $tema->titulo }} </a>
                                                                        @else 
                                                                            {{ $tema->titulo }}
                                                                        @endif

                                                                        @if ($tema->punteo)
                                                                            - <h6 style="color:#eeee93"> pts.  {{ $tema->punteo }}</h6>
                                                                        @endif
                                                                        <h6>Descripcion: {{ $tema->descripcion }}</h6>
                                                                    </div>
                                                                    <div class="col-md-4 text-right">
                                                                        @if ($tema->es_actividad == 0)
                                                                            <a href="{{ base_url() }}leccion/subir/{{ $tema->id }}" style="font-size:15px;color:white" class="" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Agregar | modificar archivo" style="color:white;"> <i class="fas fa-paperclip" style="color:white;"></i></a> |
                                                                            <a href="#" class="modificarcontenido" style="font-size:15px;color:white" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Modificar actividad" data-key="{{ $tema->titulo }}|{{$tema->punteo}}|{{$tema->descripcion}}"> <i class="fas fa-edit"></i></a> |
                                                                        @elseif($tema->es_actividad == 1)
                                                                            <a href="#" class="agregarpregunta " style="font-size:15px;color:white" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Agregar preguntas" > <i class="fas fa-question " style="color:white;"></i></a> |
                                                                            <a href="#" class="modificarvideo" style="font-size:15px;color:white" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Modificar video" data-key="{{ $tema->titulo }}|{{$tema->descripcion}}|{{$tema->link}}"> <i class="fas fa-edit"></i></a> |
                                                                        @elseif($tema->es_actividad == 2)
                                                                            <a href="#" class="agregarpregunta " style="font-size:15px;color:white;" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Construir examen" > <i class="fas fa-clipboard-check " ></i></a> |
                                                                            <a href="#" class="modificarexamen" style="font-size:15px;color:white;" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Modificar Examen" data-key="{{ $tema->titulo }}|{{$tema->descripcion}}|{{$tema->punteo}}"> <i class="fas fa-edit"></i></a> |
                                                                        @endif                                                                        
                                                                        <a href="#" class="deleteContenido  " style="font-size:15px;color:#e3446b" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Eliminar contenido"><i class="fas fa-trash "></i></a> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if (model('tema')->get_by('id',$tema->id)->archivo) 
                                                                <ol class="dd-list">
                                                                    <li class="dd-item" data-id="b-{{ $tema->id }}-{{ $leccion->id }}">
                                                                        <div class="dd-handle">
                                                                            <div class="row">
                                                                                <div class="col-md-4">
                                                                                    <a href="{{base_url()}}{{$tema->archivo}}" onclick="window.open('{{base_url()}}{{$tema->archivo}}', 'newwindow', 'width=300,height=250'); return false;" style="font-size:15px;color:white" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="">
                                                                                        @php
                                                                                            $split = explode('/', $tema->archivo);
                                                                                            $tot = count($split);
                                                                                            echo $split[ $tot - 1 ];
                                                                                        @endphp
                                                                                        </a> 
                                                                                </div>
                                                                                <div class="col-md-8 text-right">
                                                                                    <a href="#" class="deleteContenido " style="font-size:15px;color:#e3446b" id="{{ $tema->id }}" data-toggle="tooltip" data-original-title="Eliminar Archivo"> <i class="fas fa-trash "></i></a> 
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ol>
                                                            @endif
                                                            @if (model('pregunta')->get_many_by('tema_id',$tema->id))
                                                                <ol class="dd-list">
                                                                    @foreach (model('pregunta')->get_many_by('tema_id',$tema->id) as $value)
                                                                        <li class="dd-item" data-id="{{ $value->id}}-{{ $value->tema_id }}">
                                                                            <div class="dd-handle">
                                                                                <div class="row"  style="font-size:15px;color:white">
                                                                                    <div class="col-md-4" >
                                                                                         {{ $value->pregunta }}.  
                                                                                    </div>
                                                                                    <div class="col-md-8 text-right">
                                                                                        <a href="#" class="agregarrespuesta" style="font-size:15px;color:white" id="{{ $value->id }}" data-toggle="tooltip" data-original-title="Agregar respuestas"> <i class="fas fa-pencil-alt "></i></a> |
                                                                                        <a href="#" class="modificarpregunta" style="font-size:15px;color:white" id="{{ $value->id }}" data-toggle="tooltip" data-original-title="Modificar Pregunta"data-key="{{ $value->pregunta }}"><i class="fas fa-edit "></i></a> |
                                                                                        <a href="#" class="deletepregunta" style="font-size:15px;color:#e3446b;" id="{{ $value->id }}" data-toggle="tooltip" data-original-title="Eliminar pregunta"><i class="fas fa-trash "></i></a>
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
                                                                                                    <div class="col-md-8 " style="font-size:15px;color:white">
                                                                                                        {{ ++$cont }}. {{ $respuesta->respuesta }}<br> <i style="color:#eeee93"> pts. {{ $respuesta->valoracion }}</i>.
                                                                                                    </div>
                                                                                                    <div class="col-md-4 text-right">
                                                                                                        <a href="#" class="modificarrespuesta" style="font-size:15px;color:white" id="{{ $respuesta->id }}" data-toggle="tooltip" data-original-title="Modificar respuesta"data-key="{{ $respuesta->respuesta }}:{{ $respuesta->valoracion }}"><i class="fas fa-edit "></i></a> |
                                                                                                        <a href="#" class="deleterespuesta " style="font-size:15px;color:#e3446b" id="{{ $respuesta->id }}" data-toggle="tooltip" data-original-title="Eliminar respuesta"><i class="fas fa-trash "></i></a>
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
        
        
    </div>

<script type="text/javascript">
    var BASE_URL = "<?php echo base_url();?>";
    $(document).ready(function() {
        $('#btnGuardar').click(function() {
            
            Swal.fire({
                title: '<h1>Lección</h1>',
                text: '¿Estás seguro de realizar esta acción?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, agregar!',
                cancelButtonText: 'Cancelar',
                background: '#263238',
                }).then((result) => {
                    var titulo = $('#titulo').val();
                    var descripcion = $('#descripcion').val(); 
                    var curso_id = $('#curso_id').val();
                    var duracion = $('#duracion').val();
                    var data = {
                        'titulo'        : titulo,
                        'descripcion'   : descripcion,
                        'curso_id'      : curso_id,
                        'duracion'      : duracion,
                    };
                    
                if (result.value) {
                    $.ajax({
                        type:       'POST',
                        url:        BASE_URL+'leccion/agregar',
                        data:       data,
                        dataType:   'html',
                        success:    function(data) {
                            if (data != 0) {
                                Swal.fire({
                                    title:  'Agregado!',
                                    text:   'Se ha agregado el registro y se envío un correo con usuario y password para el ingreso a la plataform',
                                    type:   'success'
                                });
                                location.reload();
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
        });
        $('.modificarleccion').click(function(e) {
            var valores = e.currentTarget.getAttribute('data-key');
            var titulo = valores.split('|')[0];
            var descripcion = valores.split('|')[1];
            var duracion = valores.split('|')[2];
            
            Swal.fire({
                title: '<h2>Modificar lección</h2> ',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Titulo de la lección</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="tituloL"  name="titulo" placeholder="Título" value="'+ titulo +'" ></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Descripción de la lección</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcionL" name="descripcion" placeholder="Descripción">'+ descripcion +'</textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Duración de la lección</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="number" class="form-control" style="color:white;" id="duracionL" name="descripcion" placeholder="Duración" value="'+ duracion +'"></div></div>',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Texto"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{'texto':$('input[id="tituloL"]').val(),'id':e.currentTarget.id, 
                            'descripcion':$('textarea[id="descripcionL"]').val(), 'duracion':$('input[id="duracionL"]').val(),   }, 
                            url:BASE_URL+'tema/modificarLeccion',
                            dataType: 'html',
                            success:function(data) {
                                if (data >= 0) {
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
                })
            });
        $('.modificarexamen').click(function(e) {
            
            var valores = e.currentTarget.getAttribute('data-key');
            var titulo = valores.split('|')[0];
            var descripcion = valores.split('|')[1];
            var punteo = valores.split('|')[2];
            Swal.fire({
                title: '<h2>Modificar Examen</h2> ',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Titulo del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="titulo"  name="titulo" placeholder="Nombre" value="'+ titulo +'" ></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Descripción del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcion" name="descripcion" placeholder="Descripcion">'+ descripcion +'</textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">link del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="link"  name="link" placeholder="Punteo" value="'+ punteo +'" ></div></div>',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Texto"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{'nombre':$('input[placeholder="Nombre"]').val(),'id':e.currentTarget.id, 
                            'punteo':$('input[placeholder="Punteo"]').val(),
                            'descripcion':$('textarea[placeholder="Descripcion"]').val()},
                            url:BASE_URL+'tema/modificarExamen',
                            dataType: 'html',
                            success:function(data) {
                                if (data >= 0) {
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
                })
            });
        $('.modificarcontenido').click(function(e) {
            var valores = e.currentTarget.getAttribute('data-key');
            var titulo = valores.split('|')[0];
            var punteo = valores.split('|')[1];
            var descripcion = valores.split('|')[2];
            Swal.fire({
                title: '<h2>Modificar actividad</h2>',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Titulo de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="tituloC"  name="titulo" placeholder="Nombre" value="'+ titulo +'" ></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Descripción de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcionC" name="descripcion" placeholder="Descripcion">'+ descripcion +'</textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Punteo de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="number" class="form-control" style="color:white;" id="punteoC" name="descripcion" placeholder="Punteo" value="'+ punteo +'"></div></div>',
                showCancelButton: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Texto"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{
                                'texto':$('input[id="tituloC"]').val(),
                                'id':e.currentTarget.id, 'punteo':$('input[id="punteoC"]').val(), 'descripcion':$('textarea[id="descripcionC"]').val()},
                            url:BASE_URL+'tema/modificarContenido',
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
                })
        });
        $('.modificarvideo').click(function(e) {
            var valores = e.currentTarget.getAttribute('data-key');
            var titulo = valores.split('|')[0];
            var descripcion = valores.split('|')[1];
            var link = valores.split('|')[2];
            Swal.fire({
                title: '<h2>Modificar Titulo de contenido</h2>',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Titulo del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="titulo"  name="titulo" placeholder="Nombre" value="'+ titulo +'" ></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Descripción del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcion" name="descripcion" placeholder="Descripcion">'+ descripcion +'</textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">link del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="link"  name="link" placeholder="Link" value="'+ link +'" ></div></div>',
                showCancelButton: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Texto"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{'nombre':$('input[placeholder="Nombre"]').val(),'id':e.currentTarget.id, 
                            'link':$('input[placeholder="Link"]').val(),
                            'descripcion':$('textarea[placeholder="Descripcion"]').val()},
                            url:BASE_URL+'tema/modificarVideo',
                            dataType: 'html',
                            success:function(data) {
                                if (data <= 0) {
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
                })
        });
         $('.modificarpregunta').click(function(e) {
            var titulo = e.currentTarget.getAttribute('data-key') 
            
            Swal.fire({
                title: '<h2>Modificar Pregunta</h2> ',
                html: '<input id="text" placeholder="Texto" class="form-control mb-1" type="text" value="'+ titulo +'">',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Texto"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{'texto':$('input[placeholder="Texto"]').val(),'id':e.currentTarget.id},
                            url:BASE_URL+'tema/modificarPregunta',
                            dataType: 'html',
                            success:function(data) {
                                if (data >= 0) {
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
                })
            });
            $('.modificarrespuesta').click(function(e) {
            var valores = e.currentTarget.getAttribute('data-key');
            var titulo = valores.split(':')[0];
            var punteo = valores.split(':')[1];
            
            Swal.fire({
                title: '<h2>Modificar Respuesta</h2> ',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Respuesta</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="titulo"  name="titulo" placeholder="Texto" value="'+ titulo +'" ></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Punteo</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="link"  name="link" placeholder="Punteo" value="'+ punteo +'" ></div></div>',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: 'Modificar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FFB33D",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            Password: $('input[placeholder="Texto"]').val()
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                             data:{'texto':$('input[placeholder="Texto"]').val(),'id':e.currentTarget.id, 
                             'punteo':$('input[placeholder="Punteo"]').val()},
                            url:BASE_URL+'tema/modificarRespuesta',
                            dataType: 'html',
                            success:function(data) {
                                if (data >= 0) {
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
                })
            });

        $('.agregaractividad').click(function(e) {
            Swal.fire({
                title: '<h2><strong>Agregando actividad</strong></h2>',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Nombre de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="titulo"  name="titulo" placeholder="Nombre"></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Descripción de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcion" name="descripcion" placeholder="Descripcion"></textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Punteo de la actividad</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="number" class="form-control" style="color:white;" id="punteo"  name="punteo" placeholder="Punteo" max=100></div></div>',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#00897C",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            titulo:         $('input[placeholder="Nombre"]').val(),
                            descripcion:    $('textarea[placeholder="Descripcion"]').val(),
                            punteo:         $('input[id="punteo"]').val(),
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{
                                titulo:         $('input[Placeholder="Nombre"]').val(),
                                descripcion:    $('textarea[placeholder="Descripcion"]').val(),
                                punteo:         $('input[id="punteo"]').val(),
                                leccion:        e.currentTarget.id
                            },
                            url:BASE_URL+'leccion/actividad',
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
        $('.agregarvideo').click(function(e) {
            Swal.fire({
                title: '<h2><strong>Agregando video</strong></h2>',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Titulo del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="titulo"  name="titulo" placeholder="Nombre"></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Descripción del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcion" name="descripcion" placeholder="Descripcion"></textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">link del video</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="link"  name="link" placeholder="Link"></div></div>',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#00897C",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            titulo:         $('input[placeholder="Nombre"]').val(),
                            descripcion:    $('textarea[placeholder="Descripcion"]').val(),
                            link:           $('input[placeholder="Link"]').val(),
                        });
                    });
                },
                allowOutsideClick: false
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type:'POST',
                            data:{
                                titulo:         $('input[Placeholder="Nombre"]').val(),
                                descripcion:    $('textarea[placeholder="Descripcion"]').val(),
                                link:           $('input[placeholder="Link"]').val(),
                                leccion:        e.currentTarget.id
                            },
                            url:BASE_URL+'leccion/video',
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
        
        $('.agregarexamen').click(function(e) {
                 Swal.fire({
                title: '<h2><strong>Agregar examen</strong></h2>',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Identificador del examen</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="text" class="form-control" style="color:white;" id="titulo"  name="titulo" placeholder="Nombre"></div></div>' + 
                        '<div class="form-group text-left"><label for="exampleInputuname">Instrucciones del examen</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcion" name="descripcion" placeholder="Descripcion"></textarea></div></div>' +
                        '<div class="form-group text-left"><label for="exampleInputuname">Punteo de examen</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="number" class="form-control" style="color:white;" id="punteo"  name="punteo" placeholder="Punteo" max=100></div></div>',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#00897C",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                preConfirm: function () {
                    return new Promise((resolve, reject) => {
                        resolve({
                            titulo:         $('input[placeholder="Nombre"]').val(),
                            descripcion:    $('textarea[placeholder="Descripcion"]').val(),
                            punteo:         $('input[id="punteo"]').val(),
                        });
                    });
                },
                }).then(function (result) {
                    if (result.value) {
                        
                        $.ajax({
                            type:'POST',
                            data:{
                                titulo:         $('input[placeholder="Nombre"]').val(),
                                descripcion:    $('textarea[placeholder="Descripcion"]').val(),
                                punteo:         $('input[id="punteo"]').val(),
                                leccion:        e.currentTarget.id
                            },
                            url:BASE_URL+'leccion/examen',
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
        $('.agregarpregunta').click(function(e) {
            Swal.fire({
                title: '<h2><strong>Escribe una pregunta</strong></h2>',
                html: '<input id="pregunta" placeholder="Pregunta" class="form-control mb-1" type="text">',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#00897C",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
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
                title: '<h2><strong>Agregar respuesta</strong></h2>',
                html:   '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fas fa-pencil-alt"></i></span></div><input type="text" class="form-control" style="color:white;" name="respuesta" id="respuesta" placeholder="Respuesta"></div> <br>' + 
                        '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="fas fa-sort-numeric-up"></i></span></div><input type="number" class="form-control" style="color:white;" name="punteo" id="punteo" placeholder="Punteo"></div> <br>' +
                        '<h6 class="card-subtitle">Si la respuesta es incorrecta,   el punteo correspondiente es 0  </h6>',
                showCancelButton: true,
                confirmButtonText: 'Agregar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#00897C",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
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
                                if (data != -1) {
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
        $('.deleteLeccion').click(function(e) {
            Swal.fire({
                title: '<h2>¿Seguro quieres eliminar la lección y sus contenidos?</h2>',
                text: "¡No serás capaz de revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FE486B",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                }).then((result) => {
                if (result.value) {
                    var path = BASE_URL+'leccion/eliminar';
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
        $('.deleteContenido').click(function(e) {
            Swal.fire({
                title: '¿Seguro quieres eliminar el contenido?',
                text: "¡No serás capaz de revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FE486B",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
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
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FE486B",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
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

         $('.deleterespuesta').click(function(e) {
            Swal.fire({
                title: '¿Seguro quieres eliminar la respuesta?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminarlo!',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: "#FE486B",
                cancelButtonColor: "#DD6B55", 
                background: '#263238',
                }).then((result) => {
                if (result.value) {
                    var path = BASE_URL+'tema/eliminarRespuesta';
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
        var updateOutput = function(e) {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
            } else {
                console.log('JSON browser support required for this demo.');
            }
        };

        $('.dd').on('change', function() {
             var dataA = "";
                var dataB = "";
                var contador = 0;
                $('.dd').nestable('serialize').forEach(element => {
                    //console.log(element);
                    contador ++;
                    dataA += element.id + '-' + contador + ";";
                    if (element.children) {
                        var ctr = 0;
                        element.children.forEach(e => {
                            ctr ++;
                            dataB += e.id + '-' + ctr + ";";
                        });
                    } else {
                        //console.log('no tiene hijos');
                    }
                });
                dataA = dataA.substring(0, dataA.length - 1);
                var datos = {
                    'a' : dataA,
                    'b' : dataB,
                    };
                
                
                var BASE_URL = "<?php echo base_url();?>";
                $.ajax({
                    type:   'post',
                    url:    BASE_URL+'leccion/ordenar',
                    data:   datos,
                    dataType: 'html',
                    success:function(response) {
                        location.reload();
                    }
                });
            
        });
        $(".dd a").on("mousedown", function(event) { // mousedown prevent nestable click
            event.preventDefault();
            return false;
        });

        $(".dd a").on("click", function(event) { // click event
            event.preventDefault();
            window.location = $(this).attr("href");
            return false;
        });
            // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1
        })
        .on('change', updateOutput);
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        //$('#nestable').nestable('collapseAll');
    });
    
    </script>
    <!-- iCheck -->
    
@endsection