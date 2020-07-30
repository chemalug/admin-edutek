@php
  defined('BASEPATH') OR exit('No direct script access allowed');
 
@endphp

<aside class="left-sidebar " >
    <div class="scroll-sidebar" >
        <div class="user-profile" style="background: url({{ base_url() }}assets/components/img/background/user-info.jpg) no-repeat;">
            <!-- User profile image -->
            <a href="{{ base_url() }}"><div class="profile-img"> <img src="{{ $this->session->userdata('profile_image') }}" alt="user" height="50" /> </div></a>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ $user->first_name }} {{ $user->last_name }}</a>
            <div class="dropdown-menu animated flipInY"> 
                <a href="{{ base_url() }}perfil/mostrar" class="dropdown-item" ><i class="ti-user"></i> Mi Perfil</a> 
                <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>                            
                <a href="{{ base_url() }}auth/change_password" class="dropdown-item"><i class="ti-lock"></i> Cambiar password</a> 
                    <div class="dropdown-divider"></div> <a href="{{ base_url() }}auth/logout" class="dropdown-item"><i class="fa fa-power-off"></i> Salir </a> 
                </div>
            </div>
        </div>

                <!-- End User profile text-->
                <!-- Sidebar navigation-->
        <nav class="sidebar-nav" style="font-size:12px;" >
            Contenidos:
            <ul id="sidebarnav">
                <!--<li class="nav-small-cap">PERSONAL</li>-->
                @if ($bandera == 1)
                @foreach ($eventos as $item)
                    <li > 
                        <a class="waves-effect waves-light" href="{{ base_url() }}curso/evento/{{model('evento')->get_by('id',$item->evento_id)->no_evento}}" aria-expanded="false">
                            <i class="mdi mdi-bookmark-check"></i>
                            <span class="hide-menu">{{ model('curso')->get_by('id',model('evento')->get_by('id',$item->evento_id)->curso_id)->nombre }}</span>
                        </a>
                    </li>
                @endforeach
                    
                @else
                    @foreach ($contenidos as $item)
                        
                        <li   > <a class="has-arrow waves-effect waves-light" href="#" aria-expanded="false" style="font-size:13px;"> 
                            <i class="mdi mdi-animation" style="font-size:13px;"></i><span class="hide-menu">{{ $item->titulo }}</span></a>
                            @if (model('tema')->get_by('leccion_id',$item->id))
                                @foreach (model('tema')->order_by('orden','asc')->get_many_by('leccion_id',$item->id) as $tema)
                                    <ul aria-expanded="false" class="collapse" >
                                        <li>
                                            @if ($tema->es_actividad == '0')
                                            <a href="{{ base_url() }}actividad/mostrar_actividad/{{$tema->id}}" style="font-size:12px;">    
                                                @if (!model('nota')->get_by(['eventousuario_id'=>$this->session->userdata['eventousuarios_id'],'tema_id'=>$tema->id]))
                                                    <i class="mdi mdi-lightbulb-on-outline"></i> 
                                                @else
                                                    <i class="mdi mdi-lightbulb-on text-warning"></i>
                                                @endif
                                                 {{ $tema->titulo }}
                                            @elseif($tema->es_actividad == '1')
                                            <a href="{{ base_url() }}tema/ver/{{$tema->id}}" style="font-size:12px;"> 
                                                @if (!model('nota')->get_by(['eventousuario_id'=>$this->session->userdata['eventousuarios_id'],'tema_id'=>$tema->id]))
                                                    <i class="fas fa-check" ></i>
                                                @else
                                                    <i class="fas fa-check text-success" ></i> 
                                                @endif
                                                
                                                {{ $tema->titulo }}
                                            @elseif($tema->es_actividad == '2')
                                                @php
                                                    $intentos = 0;
                                                    $eventousuario_id =  $this->session->userdata['eventousuarios_id'];
                                                    $sql = "SELECT * FROM  notas WHERE eventousuario_id = $eventousuario_id;";
                                                    $resultado = $this->db->query($sql);

                                                    if($resultado->num_rows()>=1){
                                                            $fila = $resultado->row();
                                                            $intentos = $fila->intentos;
                                                    }
                                                    
                                                @endphp




                                            <a href="{{ base_url() }}evaluacion/confirmar/{{$tema->id}}" style="font-size:12px;" >    
                                                <i class="mdi mdi-book-open"></i> {{ $tema->titulo }}
                                            @endif
                                            
                                        </a></li>
                                    </ul>
                                    <!-- mdi-arrow-right-drop-circle -->
                                @endforeach
                                
                            @endif
                            
                        </li>
                    @endforeach
                @endif
                
            </ul>
        </nav>
    </div>
            <!-- End Bottom points-->
</aside>

<!--Intec@p2018*-->