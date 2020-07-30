
@extends('blades/index_inscribir')

@section('title', ' Principal')

@section('content')
<div class="row page-titles">

</div>

<div class="row">
    @foreach ($eventos as $evento)
        <div class="col-lg-4 col-md-4">
            <div class="card">
                <div class="card-body">   
                    <div class="col-12 inner" style="height:800px;">
                            <div><img class="img-responsive" src="https://e-learning.intecap.tech/assets/components/img/imagen.png" ></div>
                                <h3 class="text-center" >{{ $evento->curso }} </h3><br/>
                                <div style="height: 150px; padding: 15px;	overflow-y: scroll;">
                                <h6 class="card-subtitle">{{ $evento->descripcion }}</h6>
                                </div>
                            

                            <div class="col-12 small-box">
                            <br>
                                    <center><h6>Duración en horas:  <b>{{ $evento->duracion_horas }}</b> </h6></center>
                                    <span>                                    
                                    </span>
                                    @php $cupos =  ($evento->capacidad - $evento->inscritos); @endphp


                                    <h6><center>Cupos disponibles: {{ $cupos }}  <b> </b></center></h6>
                                    <center>
                                    @php  
                                    
                                    if($cupos >0){
                                     
                                        $url = 'https://e-learning.intecap.tech/inscripcion/inscripcion/' . $evento->id . "/"; 
                                        
                                        
                                    echo "<a href='$url' >Inscribete aquí   </a>";     
                                    }
                                    else{
                                        echo "<h5><b>Cupo Lleno</b></h5>";
                                    }
                                    @endphp

                                    </center>
                                    
                                    <br>
                                      
                            </div>
                            <br><br><br>
                                
                    </div>
                </div>
                    
                
                
            </div>
        </div>
    @endforeach
</div>
@includeIf('blades/_js')
@endsection