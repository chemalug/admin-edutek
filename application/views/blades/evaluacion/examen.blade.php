@extends('blades/index_examen')

@section('title', ' Agregar curso')

@section('content')


<div class="row">
    
<form class="col-lg-12" method="post" action  ="../../resultado/{{$this->data['actividad_id']}}">
        
        
        @php
        $contador = 1;  $contador2=1;
        $intentos; 



        
        @endphp
        @foreach ($this->data['resultado'] as $item)

        



        @php


            $resultado = model('respuesta')->get_many_by('pregunta_id',$item->id); 
        @endphp 
        <div class="col-lg-0"></div>
            <div class="col-lg-12">
                <div class="card" >
                    <div class="card-body">
                        <h4 class="card-title">{{$item->pregunta}}</h4>
                            @foreach($resultado as $item2)
                    <input name="pregunta{{$contador}}" type="radio" id="radio_{{$contador . $contador2}}" value="{{$item2->respuesta . "-" . $item2->valoracion . "-" . $item2->id . "-" .$this->session->userdata["identity"]}}"  />
                            <label for="radio_{{$contador. $contador2}}">{{$item2->respuesta}}</label><br/>
                        
                        @php $contador2++; @endphp            
                        @endforeach
                    </div>   
                </div>  
            </div>
            @php $contador++; @endphp
            @endforeach
    
            <div class="col-lg-0"></div>
            <div class="col-lg-12">
                <div class="card" >
                    <div class="card-body">
                        <h4 class="card-title">Enviar respuestas</h4>
                      <input type="hidden" name="otros_datos" value=" @php echo $this->data['eventousuario_id'] 
                        .  '-' . $this->data['intentos'] @endphp "> 
                      
                      
                            
                            <button type="submit" id="submit" class="btn btn-success waves-effect waves-light m-r-10">Enviar respuestas</button>
                        
                        
                        
                        
                    </div>   
                </div>  
            </div>
    
    
    
    
        </form>
</div>        
        






@endsection