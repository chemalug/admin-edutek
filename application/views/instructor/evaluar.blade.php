@extends('blades/index_i')

@section('title', ' Principal instructor')

@section('content')
<style>
    .zui-table {
    border: none;
    border-collapse: separate;
    /*border-spacing: 0;*/
    font: normal 12px;
}
.zui-table thead th {
    border: none;
    padding: 10px;
    text-align: left;
    white-space: nowrap;
}
.zui-table tbody td {
    padding: 10px;
    
    white-space: nowrap;
}
.zui-wrapper {
    position: relative;
}
.zui-scroller {
    margin-left: 260px;
    margin-right: 100px;
    #overflow-x: scroll;
    overflow-y: visible;
    padding-bottom: 5px;
    width: auto;
}
.zui-table .zui-sticky-col {
    
    left: 0;
    position: absolute;
    top: auto;
    width: 250px;
}
.zui-table .zui-sticky-col_r {
    
    right:  0;
    position: absolute;
    top: auto;
    width: 100px;
}
        
</style>
<div class="row page-titles">
    
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                @php
                    $sql1 = "SELECT * FROM eventos WHERE no_evento = '$no_evento';";   
                    $res1 = $this->db->query($sql1);             
                    $codigo_curso=0;
                    if($res1->num_rows()>0){
                        $fila1 = $res1->row();
                        $codigo_curso = $fila1->curso_id;
                        
                        $sql2 = "SELECT * FROM cursos WHERE id = $codigo_curso;";
                        $res2 = $this->db->query($sql2);             
                        if($res2->num_rows()>0){
                        $fila2 = $res2->row();
                        $nombre_curso= $fila2->nombre;
                        $logo = $fila2->logo;
                        }
                    }
                @endphp
                <div class="card-subtitle text-right row"> 
                    <div class="col-md-12 text-center"> <label id="labelActividad"></label> </div>
                    
                    
                                <img src="https://e-learning.intecap.tech/{{$logo}}" height="64">
                                
                            
                        
                        
                    <div class="col-md-8">
                        <h2 style="color:white"> <center>{{ $nombre_curso }}</center></h2> 
                        <h3 style="color:white"><center>Evento: {{ $no_evento }}</center></h3>
                    </div>
                </div>
                <div class="zui-wrapper">
                    <div class="zui-scroller">
                        <div class=" table-responsive">
                            
                            <table class="table full-color-table full-inverse-table hover-table zui-table" id="mainTable" style="cursor: pointer; font-size:12px;" role="grid" aria-describedby="editable-datatable_info" >
                                <thead>
                                    <tr>
                                        <th class="zui-sticky-col">&nbsp; <br>&nbsp; </th>
                                        @foreach (model('leccion')->get_many_by('curso_id',$evento->curso_id) as $leccion)
                                            @foreach (model('tema')->get_many_by('leccion_id',$leccion->id) as $tema )
                                                @if ($tema->es_actividad == 0)
                                                    <th colspan="2" class="text-center"><a href="{{base_url()}}tema/ponderar/{{$tema->id}}">{{ $tema->titulo }}</a> <br> {{ $tema->punteo }}</th>
                                                @elseif($tema->es_actividad == 2)
                                                    <th colspan="1" class="text-center">{{ $tema->titulo }} <br> {{ $tema->punteo }}</th>
                                                @endif
                                            @endforeach
                                        @endforeach
                                      
                                    </tr>
                                    <tr>
                                        <th class="zui-sticky-col text-center"> Nombre </th>
                                        @foreach (model('leccion')->get_many_by('curso_id',$evento->curso_id) as $leccion)
                                            @foreach (model('tema')->get_many_by('leccion_id',$leccion->id) as $tema )
                                                @if ($tema->es_actividad == 0)
                                                <th class="text-center text-warning">Punteo</th>
                                                <th class="text-center text-warning">Archivo</th>
                                                @elseif($tema->es_actividad == 2)
                                                    <th class="text-center text-warning">Punteo</th>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($eventousuarios as $eventousuario)
                                        <tr>
                                            <td class="zui-sticky-col text-white">
                                                <a href="{{ base_url() }}tema/participante/{{$eventousuario->id}}">
                                                    {{ model('user')->get_by('id',$eventousuario->user_id)->first_name }}, {{ model('user')->get_by('id',$eventousuario->user_id)->last_name }}
                                                </a>
                                            </td>
                                            @foreach (model('leccion')->get_many_by('curso_id',$evento->curso_id) as $leccion)
                                                @foreach (model('tema')->get_many_by('leccion_id',$leccion->id) as $tema )
                                                    @if ($tema->es_actividad == 0)                                                        
                                                        @if (model('archivos_tema')->get_by(['eventousuario_id' => $eventousuario->id, 'tema_id' => $tema->id]))
                                                            @if (model('nota')->get_by(['eventousuario_id'=> $eventousuario->id, 'tema_id'=>$tema->id]))

                                                                <td class="text-center text-danger" id="n-{{$eventousuario->id}}-{{$tema->id}}">{{ model('nota')->get_by(['eventousuario_id'=> $eventousuario->id, 'tema_id'=>$tema->id])->nota }}</td>
                                                            @else
                                                                @php
                                                                    $datos = array(
                                                                        'nota'				=> 0.0,
                                                                        'eventousuario_id' 	=> $eventousuario->id,
                                                                        'tema_id'			=> $tema->id,
                                                                        'intentos'			=>	0,
                                                                        'visto'				=>	1
                                                                    );
                                                                    model('nota')->insert($datos);
                                                                @endphp
                                                                <td class="text-center text-danger"> 0 </td>
                                                            @endif
                                                           
                                                            <td class="text-center text-danger" contenteditable="false"  id="a-{{$eventousuario->id}}-{{$tema->id}}">
                                                                <h3>
                                                                <a href="{{ base_url(). model('archivos_tema')->get_by(['eventousuario_id' => $eventousuario->id, 'tema_id' => $tema->id])->archivo }}" target="_blank" onclick="window.open(this.href, this.target, 'width=800 ,height=600'); return false;" data-toggle="tooltip" data-original-title="Ver | Descargar Archivo">
                                                                    <i class="mdi mdi-briefcase-download"></i>
                                                                </a> |
                                                                <a href="#" class="comentarios" id="c-{{$eventousuario->id}}-{{$tema->id}}" data-toggle="tooltip" data-original-title="Agregar comentario">
                                                                    <i class="mdi mdi-tooltip-edit"></i>
                                                                </a>
                                                                </h3> 
                                                            </td>
                                                            
                                                            
                                                        @else 
                                                        <td class="text-center text-danger">0</td>
                                                        <td class="text-center text-danger"> <a href="#" data-toggle="tooltip" data-original-title="No disponible"><i class="mdi mdi-briefcase-download text-danger"></i></a></td>
                                                        @endif
                                                    @elseif($tema->es_actividad == 2)
                                                            @php
                                                                $nota = model('nota')->get_by(['eventousuario_id' => $eventousuario->id, 'tema_id' => $tema->id]);
                                                            @endphp
                                                            <td class="text-center text-danger"> {{ isset($nota) ? $nota->nota : 0 }} </td>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                           
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

@includeIf('blades/_js')

<script src="{{base_url()}}assets/components/plugins/jquery-datatables-editable/jquery.dataTables.js"></script>
<script src="{{base_url()}}assets/components/plugins/datatables.net-bs4/js/dataTables.bootstrap4.js"></script>
<script src="{{base_url()}}assets/components/plugins/tiny-editable/mindmup-editabletable.js"></script>
<script src="{{base_url()}}assets/components/plugins/tiny-editable/numeric-input-example.js"></script>
<script>
    

    $('#tema').on('change',function(e) {
        $('#labelActividad').text ($('option:selected',this).text());
        var id = $('option:selected',this).val();
        console.log('{{ $no_evento }}');
        $('#mainTable tbody').empty();
        //$('#mainTable').find('tbody').append($('<tr><td class="zui-sticky-col">Jose miranda </td><td>archivo</td><td>0</td></tr>'));
        
    });
    
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first');
    //$('#mainTable').editableTableWidget({editor: $('<textarea>')})
    $('td:has(a)').click(function(e) {
        var content = $(this).find('a').html(); 
    });
    $('.comentarios').click(function(evt) {
        //console.log(evt.currentTarget.id);
        
        var BASE_URL = "<?php echo base_url();?>";
        
        var eventousuario = evt.currentTarget.id.split('-')[1];
        var tema = evt.currentTarget.id.split('-')[2];
        datos = {
            eventousuario : eventousuario,
            tema: tema,
            actualizacion: 0,
            comentario: "",
        };
        //console.log(datos);
        
        $.ajax({
            type:   'post',
            url:    BASE_URL+'leccion/comentario',
            data:   datos,
            dataType: 'html',
            success: function(response) {
                
                if (response == "") {
                    Swal.fire({
                        title: 'Ingrese un comentario sobre la actividad',
                        input: 'textarea',
                        inputPlaceholder: 'Comentario',
                        showCancelButton: true,
                        confirmButtonText: 'Modificar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: "#FFB33D",
                        cancelButtonColor: "#DD6B55", 
                        background: '#263238',
                    }).then((result)=> {
                        if (result.value) {
                            datos = {
                                eventousuario : eventousuario,
                                tema: tema,
                                actualizacion: 1,
                                comentario: result.value,
                            };
                            $.ajax({
                                type:   'post',
                                url:    BASE_URL+'leccion/comentario',
                                data:   datos,
                                dataType: 'html',
                            });
                        }
                    });
                } else 
                    Swal.fire({
                        title: 'Ingresa un comentario sobre la actividad',
                        input: 'textarea',
                        inputValue: response,
                        showCancelButton: true,
                        confirmButtonText: 'Modificar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: "#FFB33D",
                        cancelButtonColor: "#DD6B55", 
                        background: '#263238',
                    }).then((result)=> {
                        if (result.value) {
                            datos = {
                                eventousuario : eventousuario,
                                tema: tema,
                                actualizacion: 1,
                                comentario: result.value,
                            };
                            $.ajax({
                                type:   'post',
                                url:    BASE_URL+'leccion/comentario',
                                data:   datos,
                                dataType: 'html',
                                success: function(response) {
    
                                }
                            });
                        }
                    });
                    
                //location.reload();
            }
        });
        
        
    });
    $('#mainTable').on('change', function(evt, newValue) {
        
        
        var eventousuario = evt.target.id.split('-')[1];
        var tema = evt.target.id.split('-')[2];
        datos = {
            eventousuario : eventousuario,
            tema: tema,
            valor: newValue,
        };
        console.log(datos);
        
        if (!eventousuario) {
            location.reload();
            return;
        }
        if (evt.target.id.split('-')[0] == 'n'){
            
             var BASE_URL = "<?php echo base_url();?>";
        $.ajax({
            type:   'post',
            url:    BASE_URL+'leccion/ponderar',
            data:   datos,
            dataType: 'html',
            success:function(response) {
                
                if (response == -1) {
                    Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'No ingresaste el punteo, verifica de nuevo!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if( response == -2) {
                    Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'El punteo ingresado es mayor al asignado!',
                        showConfirmButton: false,
                        timer: 2500
                    });
                } else if( response == 1) {
                    Swal.fire({
                        position: 'center',
                        type: 'success',
                        title: 'Registro satisfactorio!',
                        text: 'Según procedimiento, es obligatorio escribir un comentario al participante, cada vez que se califique una actividad'
                        
                    });
                    $("#n-"+eventousuario+"-"+tema).text(parseFloat(newValue).toFixed(2));
                    valor = {
                        eventousuario: eventousuario
                    }
                    $.ajax({
                        type:   'post',
                        url:    BASE_URL+'leccion/getPunteo',
                        data:   valor,
                        dataType: 'html',
                        success:function(response) {
                            $("#t-"+eventousuario).text(parseFloat(response).toFixed(2));
                            
                        }
                    });
                }
                //location.reload();
            }
        });
        }
        
       
        
    });
    
    
</script>
@endsection