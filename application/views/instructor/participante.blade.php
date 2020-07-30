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
                    <h3>Evaluar actividades de: {{$usuario->first_name . ' '. $usuario->last_name }}</h3>
                    
                </div>
                <div class="table-responsive">
                    <table class="table full-color-table full-inverse-table hover-table">
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th width="25%">Actividades</th>
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
                            @foreach ($actividades as $actividad)
                            <tr>
                                <td>{{ ++$contador }}</td>
                                @php
                                    $archivo = model('archivos_tema')->get_by(['eventousuario_id' => $eventousuario_id, 'tema_id'=>$actividad->id]);
                                    $nota = model('nota')->get_by(['eventousuario_id' => $eventousuario_id, 'tema_id'=>$actividad->id]);
                                @endphp
                                <td>{{ $actividad->titulo}}</td>
                                <td>
                                    @if (isset($archivo))
                                        <a href="{{ base_url().'/'.$archivo->archivo }}" class="text-info">Descargar</a>
                                    @else
                                        No entregado
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
                                        <input type="number" class="form-control" style="color:white;" name="txt-{{$eventousuario_id}}-{{$actividad->id}}" id="txt-{{$eventousuario_id}}-{{$actividad->id}}" placeholder="Punteo" style="color:white;" value="{{$nota->nota}}">
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
                                        <input type="text" class="form-control" style="color:white;" name="ta-{{$eventousuario_id}}-{{$actividad->id}}" id="ta-{{$eventousuario_id}}-{{$actividad->id}}" placeholder="Comentario" value="{{ $archivo->comentario }}">
                                        </div>
                                    @else
                                        No existe
                                    @endif
                                </td>
                                <td>
                                    @if(isset($archivo)) 
                                    <button type="button" class="btn btn-outline-info guardar" name="btn-{{$eventousuario_id}}-{{$actividad->id}}" id="btn-{{$eventousuario_id}}-{{$actividad->id}}">
                                        <i class="fa fa-save"></i> Guardar
                                    </button>
                                    @else
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
    });

 
</script>

@endsection