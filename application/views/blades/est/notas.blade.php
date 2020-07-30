@extends('blades/index_e')

@section('title', ' Principal')

@section('content')
<div class="row page-titles">

</div>
<div class="row">

        <div class="col-md-12" >  
                <div class="card card-inverse">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Notas de las actividades ponderadas</h4></div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table full-color-table full-inverse-table hover-table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actividades</th>
                                                    <th>Entregado</th>
                                                    <th>Nota</th>
                                                    <th>Comentario</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $contador = 0;
                                                @endphp
                                                @foreach ($temas as $item)
                                                @if ($item->punteo != 0)
                                                    @if ($item->es_actividad == 0)
                                                        <tr>
                                                            <td>{{ ++$contador }}</td>
                                                            <td>{{ $item->titulo}}</td>

                                                            <td>{{ (model('archivos_tema')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id])) == null ? 'No entregado' : 'Entregado' }}</td>
                                                            <td>{{ (model('nota')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id]))== null ? '0.00': model('nota')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id])->nota }}</td>
                                                            <td>{{ (model('archivos_tema')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id])) == null ? 'N/A' : model('archivos_tema')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id])->comentario }}</td>
                                                        </tr>
                                                    @elseif ($item->es_actividad == 2)
                                                        <tr>
                                                            <td>{{ ++$contador }}</td>
                                                            <td>{{ $item->titulo}}</td>

                                                            <td>{{ (model('nota')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id])) == null ? 'No realizado' : 'Realizado' }}</td>
                                                            <td>{{ (model('nota')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id])) == null ? '0.00': model('nota')->get_by(['eventousuario_id' => $this->session->userdata('eventousuario_id'), 'tema_id' => $item->id])->nota }}</td>
                                                            <td></td>
                                                        </tr>
                                                    @endif
                                                @endif
                                                
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                       
            </div>
        </div>




         
         
         
         
 
    


</div>
@includeIf('blades/_js')
@endsection