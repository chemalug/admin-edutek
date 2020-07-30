@php
  defined('BASEPATH') OR exit('No direct script access allowed')
@endphp

@section('title', ' Login') 

@include('blades/_init')

@includeIf('blades/_meta')

@include('blades/_css')
<script src='https://www.google.com/recaptcha/api.js'></script>
  
</head>
<body>
 
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    
    <section id="wrapper" >  
        <div class="login-register login-sidebar" style='background-image: url("{{ base_url() }}assets/components/images/background/login-register.jpg")'>

        
            <div class="login-box card">
                <div class="card-body">
                  @if (isset($message))
                    <div class="alert alert-success alert-dismissible" id="infoMessage">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4 style="color:black;"><i class="icon fa fa-warning"></i> Alerta!</h4>
                        {{$message}}
                    </div>
                  @endif
                  {{form_open("auth/login")}}
                    <a href="javascript:void(0)" class="text-center db">
                        <img src="https://edutek.org.gt/wp-content/uploads/2020/02/edu.png" alt="Home" /><br/>
                    </a>
                        <h3 class="box-title m-b-20">Iniciar sesión</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" style="color:white;" type="text" required="" placeholder="Email" name="identity"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" style="color:white;" type="password" required="" placeholder="Password" name="password"> </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex no-block align-items-center">
                                
                                <div class="ml-auto">
                                    <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fa fa-lock m-r-5"></i> {{lang('login_forgot_password')}}</a> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Ingresar</button>
                            </div>
                        </div>
            
                    </form>
                    <form class="form-horizontal" method="POST" id="recoverform" action="{{ base_url() }}auth/reset_password">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recuperar password</h3>
                                <p class="text-muted">Ingrese su correo electrónico registrado y se le enviarán las nuevas credenciales! </p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" style="color:white;" type="text" required="" placeholder="Email" name="email_reset"> </div>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6LeP7KcUAAAAAB_lkdQ9aJRb9ECC14t6Ff4dzJTn"></div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 
    </section>
    @include('blades/_js')
    
</body>
</html>