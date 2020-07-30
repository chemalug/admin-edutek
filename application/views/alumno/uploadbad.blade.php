@extends('blades/index_e')

@section('title', ' Principal')

@section('content')
<div class="row page-titles">
    
</div>
<div class="row">
@if ($bandera == 1)
    @foreach ($eventos as $evento)
        <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    @php
                        $data = model('evento')->get_by('id',$evento->evento_id);
                    @endphp
                    <a href="{{ site_url() }}curso/evento/{{ $data->no_evento }}">
                        <div class="row">
                            <div class="col-12 inner">
                                <h3>Evento: </h3> <h4><code> {{ $data->no_evento }}</code> </h4>
                                <h6 class="card-subtitle">Detalle del evento</h6>
                            </div>
                            <div class="col-12 small-box">
                                <h3 class="text-right">{{ $evento->progreso }}</h3>
                                @if ($data->estado == 0)
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $evento->progreso }}% ; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="icon">
                                        <span class="text-danger">
                                            <i class=" text-danger mdi mdi-book-variant"> </i> Finalizado
                                        </span>
                                    </div>
                                @else
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $evento->progreso }}% ; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="icon">
                                        <span>
                                            <i class=" text-success mdi mdi-book-variant"> </i> En ejecución
                                        </span>
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                    
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@else
   
@endif
</div>
@includeIf('blades/_js')
@endsection