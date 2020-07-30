@extends('blades/index_e')

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
    
</div>
<div class="row" style="height:675px;">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card" >
            <div class="card-body" >
                @if(isset($asunto)) 
                    <h2>Mensajes {{ $asunto->asunto }}</h2>
                    <div class="scroll" id="messageBody" >
                        @foreach ($mensajes as $mensaje)
                            @if ($mensaje->destino == 'E')
                                <div class="container mensajenuevo">
                                    <img src="{{ base_url() }}assets/components/img/teacher.png" alt="Avatar" style="width:100%;">
                                    <p>{{ $mensaje->mensaje }}</p>
                                    <span class="time-left">{{ $mensaje->fecha }}</span>
                                </div>
                            @else
                                <div class="container darker mensajenuevo">
                                    <img src="{{ base_url() }}assets/components/img/profile.png" alt="Avatar" class="right" style="width:100%;">
                                    <p>{{ $mensaje->mensaje }}</p>
                                    <span class="time-right">{{ $mensaje->fecha }}</span>
                                </div>
                            @endif  
                        @endforeach
                    </div>
                    <div class="container">
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea rows="5" class="form-control form-control-line" id="texto" placeholder="Escribir respuesta..."></textarea>
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
                conversacion:   "<?php echo $conversacion;?>",
                mensaje:        texto,
            };
            $.ajax({
                type:       'POST',
                url:        BASE_URL+'mensaje/mensajenuevo',
                data:       data,
                dataType:   'html',
                success:    function(data) {
                    if (data != 0) {
                        location.reload();
                        //$('#texto').val('');
                    } else {
                       
                       //*********REVISAR POR QUE TIRA ERROR
                       // Swal.fire({
                       //     title:  'Oops...',
                       //     text:   '¡Algo salió mal!, verifica que los datos esten ingresados',
                       //     type:   'error'
                       // });
                      // location.reload();
                    }
                }
            });
            
        });

    });
    </script>
@endsection