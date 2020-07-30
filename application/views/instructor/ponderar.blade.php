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
                    <h3>Evaluar actividad {{$tema->titulo}}</h3>
                    <h5>Punteo: {{$tema->punteo}}</h5>
                </div>
                <div class="table-responsive">
                    <table class="table full-color-table full-inverse-table hover-table">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="25%">Nombre</th>
                                <th width="10%">Archivo</th>
                                <th width="15%">Punteo</th>
                                <th width="30%">Comentario</th>
                                <th width="20%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 0;
                            @endphp
                            @foreach (model('eventousuario')->get_many_by(['evento_id' => $evento->id ]) as $item)
                            <tr id="tr-{{$item->id}}-{{$tema->id}}">
                                <td>{{ ++$contador }}</td>
                                @php
                                    $usuario = model('user')->get_by('id',$item->user_id );
                                    $archivo = model('archivos_tema')->get_by(['eventousuario_id' => $item->id, 'tema_id'=>$tema->id]);
                                    $nota = model('nota')->get_by(['eventousuario_id' => $item->id, 'tema_id'=>$tema->id]);
                                @endphp
                                <td>{{ $usuario->first_name .' ' . $usuario->last_name }}</td>
                                <td>
                                    @if (isset($archivo))
                                        <a href="{{ base_url().'/'.$archivo->archivo }}" class="text-info">Descargar</a>
                                    @else
                                        @if (isset($nota))
                                            <a href="{{ base_url() }}files/archivo.pdf">Entregado por otro medio</a>
                                        @else
                                            No entregado
                                        @endif
                                    @endif
                                    
                                </td>
                                <td>
                                    @if (isset($nota))
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class=" ti-quote-left"></i>
                                                </span>
                                            </div>
                                        <input type="number" class="form-control" style="color:white;" name="txt-{{$item->id}}-{{$tema->id}}" id="txt-{{$item->id}}-{{$tema->id}}" placeholder="Punteo" style="color:white;" value="{{$nota->nota}}">
                                        </div>
                                        
                                    @else
                                        No calificado
                                    @endif
                                </td>
                                <td>
                                    @if (isset($archivo))
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="ti-receipt"></i>
                                                </span>
                                            </div>
                                        <input type="text" class="form-control" style="color:white;" name="ta-{{$item->id}}-{{$tema->id}}" id="ta-{{$item->id}}-{{$tema->id}}" placeholder="Comentario" value="{{ $archivo->comentario }}">
                                        </div>
                                    @else
                                        @if (isset($nota))
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <i class="ti-receipt"></i>
                                                    </span>
                                                </div>
                                            <input type="text" class="form-control" style="color:white;" name="ta-{{$item->id}}-{{$tema->id}}" id="ta-{{$item->id}}-{{$tema->id}}" placeholder="Comentario" value="{{ $nota->comentario }}">
                                            </div>
                                        @else 
                                            No existe
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if(isset($archivo)) 
                                    <button type="button" class="btn btn-outline-info guardar" name="btn-{{$item->id}}-{{$tema->id}}" id="btn-{{$item->id}}-{{$tema->id}}">
                                        <i class="fa fa-save"></i> Guardar
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-outline-warning calificar" name="btn-{{$item->id}}-{{$tema->id}}" id="btn-{{$item->id}}-{{$tema->id}}">
                                        <i class="fas fa-check"></i> Calificar
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
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
        var BASE_URL = "<?php echo base_url();?>";
        $('.guardar').click(function(evt) {
            var id_1 = evt.currentTarget.id.split('-')[1];
            var id_2 = evt.currentTarget.id.split('-')[2];
            var txt_id = 'txt-' + id_1 + '-' + id_2;
            var com_id = 'ta-' + id_1 + '-' + id_2;
            var txt = document.getElementById(txt_id).value;
            var com = document.getElementById(com_id).value;
            datos = {
                eventousuario_id : id_1
                ,tema_id        : id_2
                ,nota           : txt
                ,comentario     : com
            };
            $.ajax({
                type: 'POST'
                ,url: BASE_URL + 'tema/guardar'
                ,data: datos
                ,datatype: 'html'
                ,success: function(response) {
                    if (response == 1) {
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: '¡Operación satisfactoria!',
                            text: 'Registro modificado correctamente',
                            confirmButtonColor: "#FFB33D",
                            cancelButtonColor: "#DD6B55", 
                            background: '#263238',
                        });
                    } else if(response == -1) {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'No se reconoce al participante seleccionado!',
                            showConfirmButton: false
                        });
                    } else if(response == -2) {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'No se reconoce la actividad seleccionada!',
                            showConfirmButton: false
                        });
                    } else if(response == -3) {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'No se ingreso una nota válida!',
                            showConfirmButton: false
                        });
                    } else if(response == -4) {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'No se ingreso un comentario!',
                            showConfirmButton: false
                        });
                    }
                    
                }
                    
            });
        });
        $('.calificar').click(function(evt) {
            var id_1 = evt.currentTarget.id.split('-')[1];
            var id_2 = evt.currentTarget.id.split('-')[2];
            
           
            
             Swal.fire({
                title: '<h2>Calificar sin archivo</h2>',
                html:  '<div class="form-group text-left"><label for="exampleInputuname">Punteo</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><input type="number" class="form-control" style="color:white;" id="punteoC" name="descripcion" placeholder="Punteo" ></div></div>'+
                       '<div class="form-group text-left"><label for="exampleInputuname">Comentario</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text" id="basic-addon1"><i class="ti-agenda"></i></span></div><textarea class="form-control" style="color:white;" rows="4" id="descripcionC" name="descripcion" placeholder="Comentario"></textarea></div></div>' ,
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
                         datos = {
                            eventousuario_id : id_1
                            ,tema_id        : id_2
                            ,'punteo':$('input[id="punteoC"]').val()
                            , 'comentario':$('textarea[id="descripcionC"]').val()
                        };
                        console.log(datos);
                        $.ajax({
                            type: 'POST'
                            ,url: BASE_URL + 'tema/calificarsin'
                            ,data: datos
                            ,datatype: 'html'
                            ,success: function(response) {
                                if (response == 1) {
                                    Swal.fire({
                                        position: 'center',
                                        type: 'success',
                                        title: '¡Operación satisfactoria!',
                                        text: 'Registro modificado correctamente',
                                        confirmButtonColor: "#FFB33D",
                                        cancelButtonColor: "#DD6B55", 
                                        background: '#263238',
                                    });
                                } else if(response == -1) {
                                    Swal.fire({
                                        position: 'center',
                                        type: 'error',
                                        title: 'No se reconoce al participante seleccionado!',
                                        showConfirmButton: false
                                    });
                                } else if(response == -2) {
                                    Swal.fire({
                                        position: 'center',
                                        type: 'error',
                                        title: 'No se reconoce la actividad seleccionada!',
                                        showConfirmButton: false
                                    });
                                } else if(response == -3) {
                                    Swal.fire({
                                        position: 'center',
                                        type: 'error',
                                        title: 'No se ingreso una nota válida!',
                                        showConfirmButton: false
                                    });
                                } else if(response == -4) {
                                    Swal.fire({
                                        position: 'center',
                                        type: 'error',
                                        title: 'No se ingreso un comentario!',
                                        showConfirmButton: false
                                    });
                                }
                    
                            }
                                
                        });
                    }
                });
            
            
        });
    });

 
</script>

@endsection