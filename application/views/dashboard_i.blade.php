@extends('blades/index_i')

@section('title', ' Principal instructor')

@section('content')



<div class="row page-titles">
    
</div>
<div class="row">
    @foreach ($eventos as $evento)
        @php
        $fecha_inicio =$evento->fecha_inicio;
        $fecha_final = $evento->fecha_final;

        $sql = "SELECT count(*) as total FROM eventousuarios WHERE evento_id = $evento->id;";
        $result = $this->db->query($sql);
        if($result->num_rows() >0){
            $fila = $result->row();
            $cantidad_participantes = $fila->total;
        }



        $sql = "SELECT * FROM cursos WHERE id = $evento->curso_id;";
        $result = $this->db->query($sql);
        if($result->num_rows() >0){
            $fila = $result->row();
            $nombre_evento = $fila->nombre;
        }
        $porcentaje = 0;
        $f1 = new DateTime($fecha_inicio);
                        $f2 = new DateTime($fecha_final);
                        $hoy = new DateTime(date("Y-m-d"));
                        $estado_evento = "En ejecución";
                        $this->session->set_userdata('estado_evento',$estado_evento);
                        
                        $duracionTotal = $f2->diff($f1);
                        $diastotales= $duracionTotal->days;
                        $remanente    = $f2->diff($hoy);
                        $diasquefaltan = $remanente->days;
                        
                        
                        if($f2 == $f1){
                           
                        $porcentaje = 100;

                        }else{
                        $porcentaje = $remanente->days * 100 / $duracionTotal->days ;
                        $porcentaje = 100 - $porcentaje;
                        }

                        $porcentaje = round($porcentaje);


        @endphp



        <div class="col-lg-4 col-md-4">
            <div class="card">             
                <a href="{{ site_url() }}evento/evento/{{ $evento->id }}">
                    <div class="card-header">    
                        <h4 class="card-title text-center">{{ $nombre_evento}} <br/>  {{ $evento->no_evento }}  </h4>                       
                    </div>    
            <div class="card-body collapse show">    
                    
                <div class="card-text" style="color:white">
                    Fecha de inicio: {{$fecha_inicio}}<br/>
                    Fecha de finalización: {{$fecha_final}}<br/>
                    Participantes inscritos: {{$cantidad_participantes}}
                    
                </div>
                
            </div>
        
                    <div class="col-12 small-box">
                                <h3 class="text-right">{{ $porcentaje}}%</h3>
                                
                                @if ($evento->estado == 0)
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $porcentaje }}% ; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="icon">
                                        <h3>
                                            <i class=" text-danger mdi mdi-book-variant"> </i> Finalizado
                                        </h3>
                                    </div>
                                @else
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $porcentaje }}% ; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <div class="icon">
                                        <span>
                                            <i class=" text-success mdi mdi-book-variant"> </i> En ejecución
                                        </span>
                                    </div>
                                @endif
                                
                            </div>
                      
                    
                    </a>
             
                </div>
            </div>
        
        
    @endforeach
</div>
@includeIf('blades/_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
    var BASE_URL = "<?php echo base_url();?>";
    $(document).ready(function() {});
</script>
@endsection