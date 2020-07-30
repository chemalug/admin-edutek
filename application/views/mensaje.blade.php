@extends('blades/index_i')

@section('title', ' Principal')

@section('content')
<style>
        div.scroll { 
                margin:4px, 4px; 
                padding:4px; 
                width: 100%; 
                height: 400px; 
                overflow-x: hidden; 
                overflow-x: auto; 
                text-align:justify; 
            } 

        .container {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 0;
        }

        .darker {
        border-color: #ccc;
        background-color: #ddd;
        }

        .container::after {
        content: "";
        clear: both;
        display: table;
        }

        .container img {
        float: left;
        max-width: 60px;
        width: 100%;
        margin-right: 20px;
        border-radius: 50%;
        }

        .container img.right {
        float: right;
        margin-left: 20px;
        margin-right:0;
        }

        .time-right {
        float: right;
        color: #aaa;
        }

        .time-left {
        float: left;
        color: #999;
        }
    </style>
<div class="row page-titles">
    <div class="row">
        <div class="col-md-12">
            <h3>{{model('curso')->get_by('id', $this->session->userdata('curso_id'))->nombre}}:</h3> <h6>{{ model('evento')->get_by('id',$this->session->userdata('evento_id'))->no_evento}}</h6>
        </div>
    </div>
</div>
<div class="row" style="height:675px;">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body" >
                <h2>Listado de mensajes <a href="#" class="btn btn-warning waves-effect waves-light m-r-10 sendall" style="color:white;">Mensaje a todos <i class="mdi mdi-message"></i> </a></h2>
                <div class="scroll" id="messageBody_1" style="height:675px;">
                    @foreach ($participantes as $item)
                        <a href="{{ base_url() }}mensaje/ver/{{ $item->id }}" data-toggle="tooltip" data-original-title="" >                            
                            <div class="container mensajenuevo">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="{{ base_url().model('user')->get_by('id',$item->user_id)->profile_image }}" alt="Avatar"  class="img-responsive">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-12 text-danger">
                                                {{ model('user')->get_by('id',$item->user_id)->first_name . ' ' .model('user')->get_by('id',$item->user_id)->last_name}}
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-dark">
                                                Email: {{ model('user')->get_by('id',$item->user_id)->email }}
                                                @if (isset(model('conversacion')->get_by('eventousuario_id',$item->id)->estado))
                                                    @if (model('conversacion')->get_by('eventousuario_id',$item->id)->estado == 0)
                                                    <div class="notify"> 
                                                        <span class="heartbit"></span> 
                                                        <span class="point"></span> 
                                                    </div>
                                                    @endif
                                                @endif
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h6 style="color:black;font-size: 10px;">
                                                    Último acceso: {{ date('d/m/Y H:i:s',model('user')->get_by('id',$item->user_id)->last_login) }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                        </a>    
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card" >
            <div class="card-body" >
                @if(isset($asunto)) 
                <h2>Mensajes: {{ model('user')->get_by('id',model('conversacion')->get_by('id',$conversacion)->user_id)->first_name . ' ' .model('user')->get_by('id',model('conversacion')->get_by('id',$conversacion)->user_id)->last_name}} </h2>
                <div class="scroll" id="messageBody" >
                    @foreach ($mensajes as $mensaje)
                        @if ($mensaje->destino == 'E')
                            <div class="container mensajenuevo">
                                <img src="{{ $this->session->userdata('profile_image') }}" alt="Avatar" style="width:100%;" class="img-responsive">
                                <p style="color:black;">{{ $mensaje->mensaje }}</p>
                                <span class="time-left" >{{ $mensaje->fecha }}</span>
                            </div>
                        @else
                            <div class="container darker mensajenuevo" id="{{ $mensaje->id }}" >
                                <a href="#" class="editar_mensaje" id="{{ $mensaje->id  }}" >Editar</a>
                                <img src="{{ base_url().model('user')->get_by('id',model('conversacion')->get_by('id',$conversacion)->user_id)->profile_image }}" alt="Avatar" class="right" style="width:100%;" class="img-responsive">
                                <p style="color:black;">{{ $mensaje->mensaje }}</p>
                                <span class="time-right" >{{ $mensaje->fecha }}</span>
                            </div>
                        @endif  
                    @endforeach
                </div>
                
                <div class="container">
                    <div class="input-group">
                        <div class="col-md-12">
                            <textarea rows="5" class="form-control form-control-line" style="color:white;"id="texto" placeholder="Escribir respuesta..."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button class="btn bg-megna enviar" style="color:white;">Enviar</button>
                        </div>
                    </div>
                </div>
                @else
                    <div class="scroll" id="messageBody" ></div>

                    <div class="container">
                        <div class="input-group">
                            <div class="col-md-12">
                                <textarea rows="5" class="form-control form-control-line" id="texto" placeholder="Escribir respuesta..." style="color:white;"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button class="btn bg-megna enviar" style="color:white;">Enviar</button>
                            </div>
                        </div>
                    </div>
                @endif
                

            </div>
        </div>
    </div>
</div>
        
@includeIf('blades/_js')
<script>
    var BASE_URL = "<?php echo base_url();?>";
	$(document).ready(function(){
        var chatHistory = document.getElementById("messageBody");
        chatHistory.scrollTop = chatHistory.scrollHeight;
        $('.enviar').click(function(){
            var texto = $('#texto').val();
            if (!texto) {
                return;
            }
            var data = {
                conversacion:   {{$conversacion}},
                mensaje:        texto,
            };
            $.ajax({
                type:       'POST',
                url:        BASE_URL+'mensaje/mensajenuevo',
                data:       data,
                dataType:   'html',
                success:    function(data) {
                    if (data <= 0) {
                        location.reload();
                        //$('#texto').val('');
                    } else {
                       // Swal.fire({
                       //     title:  'Oops...',
                       //     text:   '¡Algo salió mal!, verifica que los datos esten ingresados',
                       //     type:   'error'
                       // });
                       location.reload();
                    }
                }
            });
            
        });
        $('.editar_mensaje').click(function(evt){
            var id = evt.currentTarget.id;
            Swal.fire({
                        title: 'Ingresa un mensaje',
                        html:   '<div class="form-group text-left"><label for="exampleInputuname">Escribir mensaje</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="mensajeD" name="descripcion" placeholder="Mensaje"></textarea></div></div>' ,
                        inputPlaceholder: 'Mensaje',
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
                    }).then((result)=> {
                        if (result.value) {
                            datos = {
                                id : id,
                                mensaje: $('textarea[id="mensajeD"]').val(),
                            };
                            console.log(datos);
                            $.ajax({
                                type:'POST',
                                data:datos,
                                url:BASE_URL+'mensaje/modificar',
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
                    });
            
        });
        $('.sendall').click(function(e) {
            Swal.fire({
                title: '<h2>Mensaje a todos </h2> ',
                html:   '<div class="form-group text-left"><label for="exampleInputuname">Mensaje a todos los participantes del evento</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="mensajeM" name="descripcion" placeholder="Mensaje"></textarea></div></div>' ,

                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonText: 'Enviar',
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
                            data:{'evento_id':{{ $evento_id }}, 
                            
                            'mensaje':$('textarea[id="mensajeM"]').val()},
                            url:BASE_URL+'mensaje/sendAll',
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
    });
    </script>
@endsection