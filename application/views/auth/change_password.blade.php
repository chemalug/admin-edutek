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
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
      
    <section id="wrapper"  class="login-register login-sidebar" style='background: url("https://i.ibb.co/6NWR6Jy/login-register.jpg") no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover;-o-background-size: cover;background-size: cover;'>  

            <div class="login-box card">
                <div class="card-body">
                  @if (isset($message))
                    <div class="alert alert-success alert-dismissible" id="infoMessage">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4 style="color:black;"><i class="icon fa fa-warning"></i> Alerta!</h4>
                        {{$message}}
                    </div>
                  @endif
                  {{form_open("auth/cambiar_password")}}
                    
                        <h3 class="box-title m-b-20">Cambiar password </h3>
                        
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" style="color:white;" type="password" required="" placeholder="Password actual" name="old_password"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" style="color:white;" type="password" required="" placeholder="Password nuevo" name="new_password"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" style="color:white;" type="password" required="" placeholder="Password confirmación" name="renew_password"> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Cambiar</button>
                            </div>
                        </div>
            
                    </form>
                   
                </div>
            </div>
        
    </section>
    @include('blades/_js')
    
</body>
</html>