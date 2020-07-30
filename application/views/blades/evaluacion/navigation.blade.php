@php
  defined('BASEPATH') OR exit('No direct script access allowed');
 
@endphp

<aside class="left-sidebar ">
    <div class="scroll-sidebar">
        <div class="user-profile" style="background: url({{ base_url() }}assets/components/img/background/user-info.jpg) no-repeat;">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{ $this->session->userdata('profile_image') }}" alt="user" /> </div>
            <!-- User profile text-->
            <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ $user->first_name }} {{ $user->last_name }}</a>
                <div class="dropdown-menu animated flipInY"> <a href="#" class="dropdown-item"><i class="ti-user"></i> Mi Perfil</a> 
                    <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>                            
                    <div class="dropdown-divider"></div> <a href="{{ base_url() }}auth/logout" class="dropdown-item"><i class="fa fa-power-off"></i> Salir </a> 
                </div>
            </div>
        </div>

                <!-- End User profile text-->
                <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!--<li class="nav-small-cap">PERSONAL</li>-->
               
                
            </ul>
        </nav>
    </div>
            <!-- End Bottom points-->
</aside>

<!--Intec@p2018*-->