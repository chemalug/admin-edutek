@extends('blades/index_e')

@section('title', ' Principal')

@section('content')
<div class="row page-titles">
    
</div>
<div class="row">
@if ($bandera != 1)
    @foreach ($temas as $item)
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3 col-md-6"></div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h2><a class="text-cyan" href="{{ site_url() }}tema/ver/{{ $item->id }}">
                                @if ($item->es_actividad == '0')
                                    <a class="text-cyan" href="{{ site_url() }}actividad/mostrar_actividad/{{ $item->id }}">
                                    @if (!model('nota')->get_by(['eventousuario_id'=>$this->session->userdata['eventousuarios_id'],'tema_id'=>$item->id]))
                                        <i class="mdi mdi-lightbulb-on-outline"></i> 
                                    @else
                                        <i class="mdi mdi-lightbulb-on text-warning"></i>
                                    @endif
                                     Actividad:  {{ $item->titulo }}
                                @elseif($item->es_actividad == '1')
                                    @if (!model('nota')->get_by(['eventousuario_id'=>$this->session->userdata['eventousuarios_id'],'tema_id'=>$item->id]))
                                        <i class="mdi mdi-check"></i> 
                                    @else
                                        <i class="mdi mdi-check text-warning"></i> 
                                    @endif 
                                    Video: {{ $item->titulo }}
                                @elseif($item->es_actividad == '2')
                                <h2><a class="text-cyan" href="{{ site_url() }}evaluacion/confirmar/{{ $item->id }}">
                                    <i class="mdi mdi-book-open"></i> Examen: <code> {{ $item->titulo }}</code>
                                @endif
                                <div style="height: 15px;"></div>
                                <h6 class="card-subtitle">{{ $item->descripcion }}</h6>
                            </a></h2>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @endforeach
@endif
</div>
@includeIf('blades/_js')
@endsection