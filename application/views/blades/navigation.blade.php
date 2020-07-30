@php
defined('BASEPATH') OR exit('No direct script access allowed');

$menues['Evento'] = array('Eventos', 'fas fa-calendar');
$menues['Upload'] = array('Cargar archivo', 'fas fa-upload');
$menues['Instructor'] = array('Instructores', 'fas fa-user');
$menues['Configuracion'] = array('Configurar sitio', 'fas fa-cog');


@endphp

<aside class="left-sidebar ">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile" style="background: url({{ base_url() }}assets/components/images/background/user-info.jpg) no-repeat;">

            <!-- User profile image -->
            <div class="profile-img"> <img src="{{ base_url() }}assets/components/images/users/1.jpg" alt="user" height="50" /> </div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ $user->first_name }} {{ $user->last_name }}</a>
                <div class="dropdown-menu animated flipInY">
                    <a href="{{ base_url() }}perfil/mostrar" class="dropdown-item"><i class="ti-user"></i>Mi Perfil</a>
                    <div class="dropdown-divider"></div> <a href="{{ base_url() }}auth/logout" class="dropdown-item"><i class="fa fa-power-off"></i> Salir </a>
                </div>
            </div>
        </div>

        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!--<li class="nav-small-cap">PERSONAL</li>-->
                <li> <a class="has-arrow waves-effect waves-light" href="#" aria-expanded="false">
                        <i class="mdi mdi-library-plus"></i><span class="hide-menu">Cursos</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ base_url() }}curso/listar"><i class="mdi mdi-book-plus"></i> Mostrar</a></li>
                        <li><a href="{{ base_url() }}curso/agregar"><i class="mdi mdi-book-plus"></i> Crear</a></li>
                    </ul>
                </li>
                
                <li> <a class="has-arrow waves-effect waves-light" href="#" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Profesores</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ base_url() }}profesor/agregar"><i class="mdi mdi-account-plus"></i> Agregar</a></li>
                        <li><a href="{{ base_url() }}profesor/asignar"><i class="mdi mdi-account-plus"></i> Mostrar</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Bottom points-->
</aside>

<!--Intec@p2018*-->